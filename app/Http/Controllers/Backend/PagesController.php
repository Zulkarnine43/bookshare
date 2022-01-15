<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Author;
use App\Publisher;
use App\Category;


class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:ame');
    }
    public function index()
    {
        $total_books = count(Book::all());
        $total_authors = count(Author::all());
        $total_publishers = count(Publisher::all());
        $total_categories = count(Category::all());



        return view('backend.pages.index', compact('total_books', 'total_authors', 'total_publishers', 'total_categories'));
    }
}
