<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registeraja() {
        return view ("/register");
    }

    public function signup(Request $request) {
        $firstname = $request->input("firstName"); 
        $lastname =  $request->input("lastName"); 
        $fullName =  $firstname .' '.$lastname;
        $bio = $request->input("biodata");

        return view("welcome", ["fullName" => $fullName, "bio" => $bio]);
    }
}
