<?php

namespace App\Http\Controllers\API;

use App\Models\Casts;
use App\Models\CastMovie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CastMovieController extends Controller
{
    public function __construct() {

        $this->middleware(['auth:api', 'isadmin'])->except(['index', 'show']);
    }

    public function index()
    {
        $Castmovie = CastMovie::get();

        return response ([
            "message" => "Berhasil Tampil cast Movie",
            "data" => $Castmovie
        ],201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'cast_id' => 'required',  
        'movie_id' => 'required',
    ],[
        'required' => 'Input :attribute field is required',  
    ]);

    CastMovie::create([
        'name' => $request->input('name'),
        'cast_id' => $request->input('cast_id'),
        'movie_id' => $request->input('movie_id'),
        
    ]);

    return response()->json([  
        "message" => "Berhasil tambah cast Movie"
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Castmovie = CastMovie::with(['movie', 'cast'])->find($id);

        if(!$Castmovie){
            return response ([
                "message" => "data $id tidak ditemukan",
            ],404);
        }

        return response ([
            "message" => "Berhasil Tampil cast Movie",
            "data" => $Castmovie
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
            'name' => 'required',
            'cast_id' => 'required',
            'movie_id' => 'required'
        ],[

            'required' => 'input :atrribute field is required,',
        ]);


        $Castmovie = CastMovie::find($id);

        $Castmovie->name = $request->input('name');
        $Castmovie->cast_id = $request->input('cast_id');
        $Castmovie->movie_id = $request->input('movie_id');

        $Castmovie->save();

        return response ([
            "message" => "Berhasil Update cast Movie",
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        
        $Castmovie = CastMovie::find($id);
        if(!$id){
            return response ([
                "message" => "data $id tidak ditemukan",
            ],404);
        }
 
        $Castmovie->delete();

        return response ([
            "message" => "Berhasil Delete cast Movie",
            // "data" => $Castmovie
        ],200);
    }

}
