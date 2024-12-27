<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function __construct() {

        $this->middleware(['auth:api', 'isadmin'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movie = Movie::all();

        return response ([
            "message" => "Data berhasil ditampilkan",
            "data" => $movie
        ],201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'summary' => 'required|min:3',
            'genre_id' => 'required|exists:genres,id',
            'poster' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'year' => 'required|digits:4',
        ],[

            'required' => 'input :atrribute field is required,',
            'max' => 'input minimal :max karakter',
            'mimes' => 'input :attribute harus jpeg,png,jpg,gif',
            'image' => 'input :attribute jika anda ingin upload maka harus gambar ya',
            'exists' => 'input :attribute tidak ditemukan',
        ]);

        $uploadedFileUrl = cloudinary()->upload($request->file('poster')->getRealPath(), [
            'folder' => 'poster',
        ])->getSecurePath();

        $movie = new Movie;

        $movie->title = $request->input('title');
        $movie->summary = $request->input('summary');
        $movie->genre_id = $request->input('genre_id');
        $movie->poster = $uploadedFileUrl;
        $movie->year = $request->input('year');

        $movie->save();

        return response ([
            "message" => "Data berhasil ditambahkan",
            "data" => $movie
        ],201);

        // Movie::create([
        //     'name' => $request->input('name'),
        // ]);

        // return response ([
        //     "message" => "Movie berhasil ditambahkan"
        // ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::with('genre','list_cast','list_review')->find($id);

        if(!$movie){
            return response ([
                "message" => "data $id tidak ditemukan",
            ],404);
        }

        return response ([
            "message" => "detail movie ditampilkan",
            "data" => $movie
        ],201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|min:3',
            'summary' => 'required|min:3',
            'genre_id' => 'required|exists:genres,id',
            'poster' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'year' => 'required|digits:4',
        ],[

            'required' => 'input :atrribute field is required,',
            'max' => 'input minimal :max karakter',
            'mimes' => 'input :attribute harus jpeg,png,jpg,gif',
            'image' => 'input :attribute jika anda ingin upload maka harus gambar ya',
            'exists' => 'input :attribute tidak ditemukan',
        ]);

        $movie = Movie::find($id);

        if($request->hasFile('poster')){
            $uploadedFileUrl = cloudinary()->upload($request->file('poster')->getRealPath(), [
                'folder' => 'poster',
            ])->getSecurePath();
            $movie->poster = $uploadedFileUrl;
        }
        
        if(!$movie){
            return response ([
                "message" => "data movie tidak ditemukan",
            ], 404);
        }

        $movie->title = $request->input('title');
        $movie->summary = $request->input('summary');
        $movie->genre_id = $request->input('genre_id');
        $movie->year = $request->input('year');

        $movie->save();

        return response ([
            "message" => "Data berhasil diupdate",
        ],201);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        
        $movie = Movie::find($id);
        if(!$id){
            return response ([
                "message" => "data $id tidak ditemukan",
            ],404);
        }
 
        $movie->delete();

        return response ([
            "message" => "Data berhasil didelete",
        ],201);
    }
}