<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id', 'book_id'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
