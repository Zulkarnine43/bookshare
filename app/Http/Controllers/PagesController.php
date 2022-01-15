<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Book;
use App\Publisher;
use App\Wishlist;
use Auth;


class PagesController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->get();
        
        


        $categories = Category::all();
        $publishers = Publisher::all();
        $books = Book::orderBy('id', 'desc')->paginate(6);

        return view('frontend.pages.index', compact('books', 'categories', 'publishers', 'wishlists'));
    }
}
