<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //

    protected $fillable = [
        'name'
    ];

    public function book()
    {
        return $this->belongsToMany('App\Book','book_authors','author_id','book_id');
    }
}