<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType ='int';
    public $timestapms = false;
}
