<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Profile;


class ProfileController extends Controller
{
    public function storeupdate(Request $request) {
        $user = auth()->user();

        $request->validate ([
            'biodata' => 'required',
            'age' => 'required|integer',
            'address' => 'required|max:255',
            
        ],[
            'required' => 'inputan :attribute harus diisi',
            'integer' => 'inputan :atribute harus bernilai angka',
        ]);

        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
        [
            'biodata' => $request->input('biodata'),
            'age' => $request->input('age'),
            'address' => $request->input('address'),
        ]);

        return response ([
            "message" => "profile berhasil dibuat/diupdate",
            "data" => $profile,
        ],201);
    }
}
