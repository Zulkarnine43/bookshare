<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\BookAuthor;

use Auth;
use File;

class BookUpdateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:ame');
    }

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
}
