<?php

namespace App\Http\Controllers\API;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
    public function __construct() {

        $this->middleware(['auth:api', 'isadmin'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Genre = Genre::get();

        return response ([
            "message" => "Berhasil Tampil semua genre",
            "data" => $Genre
        ],201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ],[

            'required' => 'input :atrribute field is required,',
            'min' => 'input minimal :min karakter'
        ]);

        Genre::create([
            'name' => $request->input('name'),
        ]);

        return response ([
            "message" => "Berhasil tambah genre"
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::with('list_movies')->find($id);

        if(!$genre){
            return response ([
                "message" => " $id tidak ditemukan",
            ],404);
        }

        return response ([
            "message" => "Berhasil Detail data dengan id : $id",
            "data" => $genre
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
            
        ],[

            'required' => 'input :atrribute field is required,',
            'min' => 'input minimal :min karakter'
        ]);


        $Genre = Genre::find($id);

        $Genre->name = $request->input('name');
       

        $Genre->save();

        return response ([
            "message" => "Berhasil melakukan update Genre id : $id ",
            "data" => $Genre
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        
        $Genre = Genre::find($id);
        if(!$id){
            return response ([
                "message" => "data $id tidak ditemukan",
            ],404);
        }
 
        $Genre->delete();

        return response ([
            "message" => "data dengan id : $id berhasil terhapus",
            "data" => $Genre
        ],200);
    }
}
