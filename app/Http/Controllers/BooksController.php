<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Publisher;
use App\Author;
use App\Category;
use App\BookAuthor;
use Auth;



class BooksController extends Controller
{
    public function show($slug)
    {

        // $books = Book::all();

        // if (!is_null($books)) {

        //     return view('frontend.pages.books.show', compact('books'));
        // }
        // return redirect()->route('index');

        $books = Book::where('slug', $slug)->first();
        if (!is_null($books)) {
            return view('frontend.pages.books.show', compact('books'));
        } else {
            return redirect()->route('index');
        }
    }
    public function search(Request $request)
    {
        $searched = $request->s;
        if (empty($searched)) {
            return $this->index();
        }
        $books = Book::orderBy('id', 'desc')->where('is_approved', 1)
            ->where('title', 'like', '%' . $searched . '%')
            ->orWhere('description', 'like', '%' . $searched . '%')
            ->paginate(3);

        foreach ($books as $book) {
            $book->increment('total_search');
            $book->save();
        }

        return view('frontend.pages.books.index', compact('books', 'searched'));
    }

    public function  advancesearch(Request $request)
    {
        $searched = $request->t;
        $searched_publisher = $request->p;

        $searched_category = $request->c;


        if (empty($searched) && empty($searched_publisher) && empty($searched_category)) {
            return $this->index();
        }

        if (!$request->t && !$request->c && $request->p) {
            $books = Book::orderBy('id', 'desc')->where('is_approved', 1)
                ->where('publisher_id',    $searched_publisher)
                ->paginate(3);
        } else if (empty($searched) && empty($searched_publisher) && !empty($searched_category)) {
            $books = Book::orderBy('id', 'desc')->where('is_approved', 1)
                ->where('category_id',    $searched_category)
                ->paginate(3);
        } else {
            $books = Book::orderBy('id', 'desc')->where('is_approved', 1)
                ->where('title', 'like', '%' . $searched . '%')
                ->orWhere('description', 'like', '%' . $searched . '%')
                ->orWhere('category_id', $searched_category)
                ->orWhere('publisher_id', $searched_publisher)

                ->paginate(3);
        }




        foreach ($books as $book) {
            $book->increment('total_search');
            $book->save();
        }

        return view('frontend.pages.books.index', compact('books', 'searched'));
    }
    public function index()
    {


        $books = Book::orderBy('id', 'desc')->where('is_approved', 1)->paginate(3);

        return view('frontend.pages.books.index', compact('books'));
    }

    public function create()
    {
        $publishers = Publisher::all();
        $categories = Category::all();
        $authors = Author::all();
        $books = Book::where('is_approved', 1)->get();

        return view('frontend.pages.books.create', compact('publishers', 'categories', 'authors', 'books'));
    }
    public function store(Request $request)
    {

        if (!Auth::check()) {
            abort(403, 'unauthorized action');
        }
        $request->validate([
            'title' => 'required|max:50',
            'category_id' => 'required',
            'publisher_id' => 'required',
            'slug' => 'nullable|unique:books',
            'description' => 'nullable',
            'image' => 'required',
        ]);

        $book = new Book();
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


        $book->is_approved = 0;
        $book->user_id = Auth::id();

        $book->save();
        //Image upload
        if ($request->image) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $name = time() . '-' . $book->id . '.' . $ext;
            $path = "images/books";
            $file->move($path, $name);
            $book->image = $name;
            $book->save();
        }


        foreach ($request->author_ids as $id) {
            $book_author = new BookAuthor();
            $book_author->book_id = $book->id;
            $book_author->author_id = $id;
            $book_author->save();
        }


        session()->flash('success', 'A Book Created Success');

        return redirect()->route('books.index');
    }
}
