<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
    public function author()
    {
        return $this->hasMany(Author::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public static function isAuthorSelected($book_id, $author_id)
    {
        $book_author = BookAuthor::where('book_id', $book_id)->where('author_id', $author_id)->first();
        if (!is_null($book_author)) {
            return true;
        }
        return false;
    }
}
