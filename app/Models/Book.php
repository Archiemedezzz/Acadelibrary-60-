<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [

        'title',
        'author',
        'publisher',
        'publication_year',
        'isbn',
        'description',
        'cover_image',
        'stock'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($book) {
            $lastBook = Book::orderBy('id', 'desc')->first();
            $number = $lastBook ? $lastBook->id + 1 : 1;
            $book->book_code = 'BK-' . str_pad($number, 5, '0', STR_PAD_LEFT);
        });
    }

    public function folders()
    {
        return $this->belongsToMany(PersonalFolder::class, 'folder_items');
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
