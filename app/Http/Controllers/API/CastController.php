<?php

namespace App\Http\Controllers\API;

use App\Models\Casts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Casts = Casts::get();

        return response ([
            "message" => "Berhasil Tampil semua cast",
            "data" => $Casts
        ],201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'age' => 'required',  
        'bio' => 'required',
    ],[
        'required' => 'Input :attribute field is required',
        // 'integer' => 'Input :attribute harus berupa angka',  
    ]);

    Casts::create([
        'name' => $request->input('name'),
        'age' => $request->input('age'),
        'bio' => $request->input('bio'),
        
    ]);

    return response()->json([  // Menggunakan response()->json untuk hasil yang lebih konsisten
        "message" => "Berhasil tambah cast"
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $casts = Casts::with(['list_movies'])->find($id);

        if(!$casts){
            return response ([
                "message" => "data $id tidak ditemukan",
            ], 404);
        }

        return response ([
            "message" => "Berhasil Detail data dengan id $id",
            "data" => $casts,
        ],201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!$id){
            return response ([
                "message" => "data $id tidak ditemukan",
            ],404);
        }

        $request->validate([
            'name' => 'required|min:3',
            'age' => 'required|min:1',
            'bio' => 'required'
        ],[

            'required' => 'input :atrribute field is required,',
            'min' => 'input minimal :min karakter'
        ]);


        $Casts = Casts::find($id);

        $Casts->name = $request->input('name');
        $Casts->age = $request->input('age');
        $Casts->bio = $request->input('bio');

        $Casts->save();

        return response ([
            "message" => "Berhasil melakukan update Cast id : $id",
            "data" => $Casts
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        
        $Casts = Casts::find($id);
        if(!$id){
            return response ([
                "message" => "data $id tidak ditemukan",
            ],404);
        }
 
        $Casts->delete();

        return response ([
            "message" => "data dengan id : $id berhasil terhapus",
            "data" => $Casts
        ],200);
    }
}
