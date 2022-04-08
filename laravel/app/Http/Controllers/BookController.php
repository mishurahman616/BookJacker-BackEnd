<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\BookModel;
class BookController extends Controller
{
    
    function selectAll(){
        $result = BookModel::all();
        return $result;
    }
    function selectBookById($id){
      $result = BookModel::findOrFail($id);
      return $result;
    }
    function selectBookByName($name){
        $name=urldecode($name);
        $result= DB::table('tbl_books')->where('title', $name)->first();
        return response()->json($result);
      }
    function insertBook(Request $book){
        $insert = new BookModel;
        $insert->bookTitle = addslashes(htmlspecialchars(trim($book->bookTitle)));
        $insert->bookImage = addslashes(htmlspecialchars(trim($book->bookImage)));
        $insert->bookDesc = addslashes(htmlspecialchars(trim($book->bookDesc)));
        $insert->author = addslashes(htmlspecialchars(trim($book->author)));
        $insert->genre = addslashes(htmlspecialchars(trim($book->genre)));
        $insert->rating = addslashes(htmlspecialchars(trim($book->rating)));
        $insert->save();
       



    }
}
