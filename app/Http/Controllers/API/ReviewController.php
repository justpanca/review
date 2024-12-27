<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\GenerateEmailMail;
// use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function storeupdate(Request $request) {
        $user = auth()->user();

        $request->validate ([
            'critic' => 'required',
            'rating' => 'required|between:1,5',
            'movie_id' => 'required|exists:movies,id',
            
        ],[
            'required' => 'inputan :attribute harus diisi',
            'integer' => 'inputan :atribute harus bernilai angka',
        ]);

        $review = Review::updateOrCreate(
        ['user_id' => $user->id],

        [
            // 'id' => Str::uuid(),
            'critic' => $request->input('critic'),
            'rating' => $request->input('rating'),
            'movie_id' => $request->input('movie_id'),
           
        ]);

        return response ([
            "message" => "review berhasil dibuat/diupdate",
            "data" => $review,
        ], 201);
    }
}

