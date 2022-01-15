<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Publisher;
use App\Author;
use App\Category;
use App\BookAuthor;
use App\User;

use Auth;



class UsersController extends Controller
{
    public function profile($username)
    {
        $users = User::where('username', $username)->first();
        if (!is_null($users)) {
            $books = $users->books()->paginate(1);

            return view('frontend.pages.users.show', compact('users', 'books'));
        }
        return redirect()->route('index');
    }
    // public function book($username)
    // {
    //     $users = User::where('username', $username)->first();
    //     if (!is_null($users)) {
    //         $books = $users->books;

    //         return view('frontend.pages.users.show', compact('users'));
    //     }
    //     return redirect()->route('index');
    // }
}
