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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return view('backend.pages.books.index', compact('books'));
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
        // $category =  Category::find($id);
        // $request->validate([
        //     'name' => 'required|max:25',
        //     'slug' => 'nullable|unique:categories,slug,' . $category->id,
        //     'description' => 'nullable',
        // ]);


        // $category->name = $request->name;
        // if (empty($request->slug)) {
        //     $category->slug = str_slug($request->name);
        // } else {
        //     $category->slug = $request->slug;
        // }

        // $category->parent_id = $request->parent_id;
        // $category->description = $request->description;

        // $category->save();
        // session()->flash('success', 'A Category Updated Success');

        // return back();

        $book =  Book::find($id);

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

        // $book->is_approved = 1;
        // $book->user_id = 1;

        $book->save();
        //Image upload

        if (File::exists('images/books/' . $book->image)) {
            File::delete('images/books/' . $book->image);
        }

        if ($request->image) {
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
        $child_categories = Category::where('parent_id', $id)->get();
        foreach ($child_categories as $child)
            $child->delete();
        $categories =  Category::find($id);
        $categories->delete();
        session()->flash('success', 'A Category Deleted Success');

        return back();
    }
}
