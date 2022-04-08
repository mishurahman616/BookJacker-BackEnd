<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingModel extends Model
{
    protected $table = 'tbl_reading';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType ='int';
    public $timestapms = false;
}
