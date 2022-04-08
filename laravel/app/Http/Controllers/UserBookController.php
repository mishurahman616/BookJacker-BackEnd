<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use App\Models\UserBookModel;
use App\Models\UserModel;

class UserBookController extends Controller
{
    function uploadBook(Request $request)
    {
        if ($request->hasFile('book')) {
            if ($request->input('email') == "") {
                $status = "Please Login first !";
                return response()->json(['status' =>  $status]);
            }
            $ext = $request->file('book')->getClientOriginalExtension();
            if ($ext === 'pdf') {
                $title = $request->input('bookTitle');
                $author = $request->input('author');
                $genre = $request->input('genre');
                $email = $request->input('email');
                $bookImage = "";


                $user = DB::table('tbl_user')->where('email', $email)->first();
                if (!$user) {
                    $status = "Please Login first !";
                    return response()->json(['status' =>  $status]);
                }
                if (Hash::check($request->input('password'), $user->password)) {
                    if ($request->hasFile('cover')) {
                        $coverImageName = 'bookjacker' . time() . '.' . $request->file('cover')->getClientOriginalExtension();
                        $request->file('cover')->move('cover/', $coverImageName);
                        $bookImage = 'http://' . $_SERVER['HTTP_HOST'] . '/public/cover/' . $coverImageName;
                    }

                    $fileName = 'bookjacker' . time() . '.' . $request->file('book')->getClientOriginalExtension();
                    $request->file('book')->move('pdf/', $fileName);
                    $bookUrl = $fileName;
                    if ($title == "") {
                        $title = $fileName;
                    }


                    try {
                        $user = UserBookModel::create([
                            'userId' => $user->id,
                            'bookTitle' => $title,
                            'bookImage' => $bookImage,
                            'bookUrl' => $bookUrl,
                            'bookDesc' => '',
                            'author' => $author,
                            'genre' => $genre,
                            'rating' => 0,
                            'edition' => ''

                        ]);
                        $status = "Uploaded Sucessfully";
                    } catch (Exception $e) {
                        $status = "Error occured while Uploading" . $e;
                        if (str_contains($e->getMessage(), "Duplicate"))
                            $status = "Error Occured | Try again ";
                    }
                } else {
                    $status = "Wrong Password or Login Again!";
                }
            }else $status = "Only Pdf is allowed!";
        } else  $status = "The file is missing or file has problem!";

        return response()->json(['status' =>  $status]);
    }

    function getUserBooks(Request $request)
    {
        $books = UserBookModel::where('userId', $request->input('userId'))->get();
        return response()->json($books);
    }

    function getUserBookById(Request $request)
    {
        $book = UserBookModel::where('bookId', $request->input('bookId'))->first();

        return response()->json($book);
    }
    function bookDeleteById(Request $request)
    {
        $book = UserBookModel::find($request->input('bookId'));
        $result =  $book->delete();
        if ($result) {
            return response()->json(["status" => "Deleted successfully"]);
        } else {
            return response()->json(["status" => "Cannot Delete"]);
        }
    }
}
