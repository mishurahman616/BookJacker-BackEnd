<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBookModel extends Model
{
    protected $table = 'tbl_userbooks';
    protected $primaryKey = 'bookId';
    public $incrementing = true;
    protected $keyType ='int';
    public $timestapms = false;

    protected $fillable = [
        'userId', 'bookTitle', 'bookImage', 'bookUrl', 'bookDesc', 'author', 'genre', 'rating', 'edition'
    ];
    public $timestamps = false;
}
