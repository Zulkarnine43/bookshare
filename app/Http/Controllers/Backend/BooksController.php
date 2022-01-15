<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Book;
use App\Category;
use App\Publisher;
use App\Author;
use App\BookAuthor;
use File;








class BooksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:ame');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->get();

        return view('backend.pages.books.index', compact('books'));
    }
    public function unapprove()
    {
        $books = Book::orderBy('id', 'desc')->where('is_approved', 0)->get();
        $approved = false;
        return view('backend.pages.books.index', compact('books', 'approved'));
    }

    public function approvebook()
    {
        $books = Book::orderBy('id', 'desc')->where('is_approved', 1)->get();
        $approved = false;
        return view('backend.pages.books.index', compact('books', 'approved'));
    }
    public function approve($id)
    {
        $book = Book::find($id);
        if (!is_null($book)) {
            $book->is_approved = 1;
            $book->save();
        }

        session()->flash('success', 'Book has been approved');
        return back();
    }
    public function unapprovebook($id)
    {
        $book = Book::find($id);
        if (!is_null($book)) {
            $book->is_approved = 0;
            $book->save();
        }

        session()->flash('success', 'Book has been Unapproved');
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $publishers = Publisher::all();
        $categories = Category::all();
        $authors = Author::all();
        $books = Book::where('is_approved', 1)->get();

        return view('backend.pages.books.create', compact('publishers', 'categories', 'authors', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|max:50',
            'category_id' => 'required',
            'publisher_id' => 'required',
            'slug' => 'nullable|unique:books',
            'description' => 'nullable',
            'image' => 'required',
            'quantity' => 'required|numeric',
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



        $book->is_approved = 1;
        $book->user_id = 1;

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

        return redirect()->route('admin.books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        $publishers = Publisher::all();
        $categories = Category::all();
        $authors = Author::all();
        $books = Book::where('is_approved', 1)->where('id', '!=', $id)->get();

        return view('backend.pages.books.edit', compact('publishers', 'categories', 'authors', 'books', 'book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $book =  Book::find($id);

        $request->validate([
            'title' => 'required|max:50',
            'category_id' => 'required',
            'publisher_id' => 'required',
            'slug' => 'nullable|unique:books,slug,' . $book->id,
            'description' => 'nullable',
            'image' => 'nullable',
            'quantity' => 'required|numeric',
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

        return redirect()->route('admin.books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
}
