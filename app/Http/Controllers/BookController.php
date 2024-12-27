<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookController extends Controller
{
    public function create() {
        return view("post.add");
    }

    public function store(Request $request) {
        
        $request->validate([
            'title' => 'required|min:3',
            'summary' => 'required|min:3',
            'author' => 'required|min:3',
            'release_year' => 'required|digits:4',

        ]);

        $now = Carbon::now();

        DB::table('books')->insert([
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'author' => $request->input('author'),
            'release_year' => $request->input('release_year'),
            'created_at' => $now,
            'updated_at' => $now,

        ]);

             return redirect("/book");

        

    }

    public function index() {
            $laravel = DB::table('books')->get();


            return view("post.tampil", ["books"=> $laravel]);
    }

    public function show($id) {
       $laravel = DB::table("books")->find($id);

       return view("post.detail", ["post"=>$laravel]);
    }

    public function edit($id) {
        $laravel = DB::table("books")->find($id);

       return view("post.edit", ["post"=>$laravel]);
    }

    public function update($id, Request $request) {
        
        $request->validate([
            'title' => 'required|min:3',
            'summary' => 'required|min:3',
            'author' => 'required|min:3',
            'release_year' => 'required|digits:4',

        ]);

        $now = Carbon::now();

        DB::table('books')
              ->where('id', $id)
              ->update(
                [
                    'title' => $request->input('title'),
                    'summary' => $request->input('summary'),
                    'author' => $request->input('author'),
                    'release_year' => $request->input('release_year'),
                    'updated_at' => $now,
                ]);

                return redirect("/book");
    }

    public function destroy($id) {
        DB::table('books')->where('id', '=', $id)->delete();

        return redirect("/book");
    }
}
