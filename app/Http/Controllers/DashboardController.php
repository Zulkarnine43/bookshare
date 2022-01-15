<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Book;
use App\BookAuthor;
use App\Publisher;
use App\Author;
use App\BookRequest;
use App\Category;

use File;
use Auth;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = Auth::user();
        if (!is_null($users)) {
            $books = $users->books;

            return view('frontend.pages.users.dashboard', compact('users', 'books'));
        }
        return redirect()->route('index');
    }

    public function books()
    {
        $users = Auth::user();

        if (!is_null($users)) {
            $books = $users->books;

            return view('frontend.pages.users.dashboard_books', compact('users', 'books'));
        }
        return redirect()->route('index');
    }
    public function bookRequestlist()
    {
        $user = Auth::user();

        if (!is_null($user)) {
            $book_requests = BookRequest::where('ownear_id', $user->id)->orderBy('id', 'desc')->paginate(10);

            return view('frontend.pages.users.request_books', compact('user', 'book_requests'));
        }
        return redirect()->route('index');
    }
    public function bookordertlist()
    {
        $user = Auth::user();

        if (!is_null($user)) {
            $book_orders = BookRequest::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);

            return view('frontend.pages.users.orders_books', compact('user', 'book_orders'));
        }
        return redirect()->route('index');
    }
    public function bookorderapprove(Request $request, $request_id)
    {


        $book_request =  BookRequest::find($request_id);


        if (!is_null($book_request)) {


            $book_request->status = 4; // confirmed by user
            $book_request->save();
            $book = Book::find($book_request->book_id);
            $book->decrement('quantity');

            session()->flash('success', 'Book Order has been confirmed!!');

            return  back();
        } else {
            session()->flash('error', 'No Book Found  !!');

            return  back();
        }
    }
    public function bookorderreturn(Request $request, $request_id)
    {


        $book_request =  BookRequest::find($request_id);


        if (!is_null($book_request)) {


            $book_request->status = 6; // Book return
            $book_request->save();



            session()->flash('success', 'Book Return !!');

            return  back();
        } else {
            session()->flash('error', 'No Book Found  !!');

            return  back();
        }
    }
    public function bookorderreturnconfirm(Request $request, $request_id)
    {


        $book_request =  BookRequest::find($request_id);


        if (!is_null($book_request)) {



            $book_request->status = 7; // Book return  Confirm
            $book_request->save();
            $book = Book::find($book_request->book_id);
            $book->increment('quantity');



            session()->flash('success', 'Book Return has been successfully !!');

            return  back();
        } else {
            session()->flash('error', 'No Book Found  !!');

            return  back();
        }
    }

    public function bookorderreject(Request $request, $request_id)
    {


        $book_request =  BookRequest::find($request_id);


        if (!is_null($book_request)) {


            $book_request->status = 5; // rejected by user
            $book_request->save();

            session()->flash('success', 'Book Request has been rejected!!');

            return  back();
        } else {
            session()->flash('error', 'No Book Found  !!');

            return  back();
        }
    }








    public function bookEdit($slug)
    {
        $book = Book::where('slug', $slug)->first();
        $publishers = Publisher::all();
        $categories = Category::all();
        $authors = Author::all();
        $books = Book::where('is_approved', 1)->where('slug', '!=', $slug)->get();

        return view('frontend.pages.users.edit', compact('publishers', 'categories', 'authors', 'books', 'book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bookupdate(Request $request, $slug)
    {


        $book =  Book::where('slug', $slug)->first();

        $request->validate([
            'title' => 'required|max:50',
            'category_id' => 'required',
            'publisher_id' => 'required',
            'slug' => 'nullable|unique:books,slug,' . $book->id,
            'description' => 'nullable',
            'image' => 'nullable',
        ]);

        $book->title = $request->title;
        if (empty($request->slug)) {
            $book->slug = str_slug($request->title);
        } else {
            $book->slug = $request->slug;
        }

        $book->category_id = $request->category_id;
        $book->publisher_id = $request->publisher_id;
        $book->publish_year = $request->publish_year;

        $book->description = $request->description;
        $book->translator_id = $request->translator_id;

        $book->isbn = $request->isbn;
        $book->quantity = $request->quantity;


        // $book->is_approved = 1;
        // $book->user_id = 1;

        $book->save();
        //Image upload


        if ($request->image) {

            if (File::exists('images/books/' . $book->image)) {
                File::delete('images/books/' . $book->image);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $name = time() . '-' . $book->id . '.' . $ext;
            $path = "images/books";
            $file->move($path, $name);
            $book->image = $name;
            $book->save();
        }
        $book_author = BookAuthor::where('book_id', $book->id)->get();
        foreach ($book_author as $author) {
            $author->delete();
        }

        foreach ($request->author_ids as $id) {
            $book_author = new BookAuthor();
            $book_author->book_id = $book->id;
            $book_author->author_id = $id;
            $book_author->save();
        }


        session()->flash('success', 'A Book Updated Success');

        return redirect()->route('users.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bookDelete($id)
    {
        $book = Book::find($id);
        if (!is_null($book)) {
            if (!is_null($book->image)) {
                $file_path = "images/books/" . $book->image;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            $book_authors = BookAuthor::where('book_id', $book->id)->get();
            foreach ($book_authors as $author) {
                $author->delete();
            }
            $book->delete();
        }
        session()->flash('success', 'A Book has deleted success');
        return back();
    }


    public function bookRequest(Request $request, $slug)
    {


        $book =  Book::where('slug', $slug)->first();

        $request->validate(
            [
                'user_message' => 'required|max:300',
            ],

            [
                'user_message.required' => 'Please write your message for request to the book !! '

            ]
        );
        if (!is_null($book)) {

            $book_requesst = new BookRequest();
            $book_requesst->book_id = $book->id;
            $book_requesst->user_id = Auth::id();
            $book_requesst->ownear_id = $book->user_id;

            $book_requesst->status = 1;
            $book_requesst->user_message = $request->user_message;
            $book_requesst->save();

            session()->flash('success', 'Book has been request to the user !!');

            return  back();
        } else {
            session()->flash('error', 'No Book Found  !!');

            return  back();
        }
    }
    public function bookRequestupdate(Request $request, $request_id)
    {


        $book_request =  BookRequest::find($request_id);

        $request->validate(
            [
                'user_message' => 'required|max:300',
            ],

            [
                'user_message.required' => 'Please write your message for request to the book !! '

            ]
        );
        if (!is_null($book_request)) {


            $book_request->user_message = $request->user_message;
            $book_request->save();

            session()->flash('success', 'Book Request has been Updated !!');

            return  back();
        } else {
            session()->flash('error', 'No Book Found  !!');

            return  back();
        }
    }

    public function bookRequestapprove(Request $request, $request_id)
    {


        $book_request =  BookRequest::find($request_id);


        if (!is_null($book_request)) {


            $book_request->status = 2; // confirmed by owner
            $book_request->save();

            session()->flash('success', 'Book Request has been Approved and sent to the user!!');

            return  back();
        } else {
            session()->flash('error', 'No Book Found  !!');

            return  back();
        }
    }

    public function bookRequestreject(Request $request, $request_id)
    {


        $book_request =  BookRequest::find($request_id);


        if (!is_null($book_request)) {


            $book_request->status = 3; // rejected by owner
            $book_request->save();

            session()->flash('success', 'Book Request has been rejected and sent to the user!!');

            return  back();
        } else {
            session()->flash('error', 'No Book Found  !!');

            return  back();
        }
    }

    public function bookRequestdelete($request_id)
    {
        $book_request =  BookRequest::find($request_id);


        if (!is_null($book_request)) {
            $book_request->delete();





            session()->flash('success', 'Book Request Deleted success !!');

            return  back();
        } else {
            session()->flash('error', 'No Book Found  !!');

            return  back();
        }
    }
}
