<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  function userRegister(Request $request)
  {
    $fname = $request->input('fname');
    $lname = $request->input('lname');
    $email = $request->input('email');
    $phone = $request->input('phone');
    $password = $request->input('password');
    try {
      $user = User::create([
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
        'phone' => $phone,
        'password' => Hash::make($password)
      ]);
      $status = "Registerd Sucessfully";
    } catch (Exception $e) {
      $status = "Error occured while registering";
      if (str_contains($e->getMessage(), "Duplicate"))
        $status = "Already Account Exist with this Email: " . $email;
    }


    return response()->json(['status' => $status]);
  }


  function userLogin(Request $request)
  {
    try {
      $user = "";
      $user = User::where('email', $request->input('email'))->first();
     
      if(!$user){
        return response()->json(['status' =>"No Account Found with this Email. Please Register!"]);
      }
      $password = $user->password;
      if (Hash::check($request->input('password'), $password)) {
        $status = "Login Successfull";
      } else {
        $user = "";
        $status = "Email or Password Mismatched!";
      }
    } catch (Exception $e) {
      $status = "Login Failed" . $e->getMessage();
    }

    return response()->json(['user' => $user, 'status' => $status]);
  }


  function getUserAllUsers()
  {
    $resutl = User::all();
    return $resutl;
  }
  function getUserById($id)
  {
    $resutl = User::findOrFail($id);
    return $resutl;
  }
  function getUserByName($name)
  {
    $resutl = User::where('name', $name)->get();
    return $resutl;
  }
  function addUser(Request $request)
  {
    $fname = $request->input('fname');
    $lname = $request->input('lname');
    $email = $request->input('email');
    $phone = $request->input('phone');
    $password = $request->input('password');
  }
}
