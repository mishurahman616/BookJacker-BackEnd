<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function testcall()
    {
        $result= DB::table('tbl_books')->where('title', 'Beating the Street')->first();
        return response()->json($result);
    }
}
