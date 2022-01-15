<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use App\User;

use Auth;

class WishlistController extends Controller
{

    public function wishlist_add($id)
    {
        $crop = crop_import::find($id);

        $wishlist = new wishlist();
        $wishlist->crop_id = $crop->id;
        $wishlist->f_username = $crop->username;
        $wishlist->c_username = Session::get('c_username');
        $wishlist->save();
        return redirect('/')->with('msg', 'wishlist added successfully');
    }

    public function wishlist()
    {

        $wishlists = Wishlist::where('user_id', Auth::id())->paginate(5);
        return view('frontend.pages.wishlist', compact('wishlists'));
    }
}
