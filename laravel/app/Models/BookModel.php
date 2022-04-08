<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    protected $table = 'tbl_books';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType ='int';
    public $timestamps = false;
   
}
