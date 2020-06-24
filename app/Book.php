<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = ['name', 'isbn','country', 'number_of_pages','publisher', 'release_date'];

    public function author()
    {
        return $this->belongsTo(Authors::class);
    }
}