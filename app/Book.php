<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //

    protected $fillable = [
        'name','description'
    ];

    public function author()
    {
        return $this->belongsToMany('App\Author','book_authors','book_id','author_id');
    }
}