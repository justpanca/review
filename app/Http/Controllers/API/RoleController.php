<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{

    public function __construct() {

        $this->middleware(['auth:api', 'isadmin'])->except(['index', 'show']);
    }
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();

        return response ([
            "message" => "Data berhasil ditampilkan",
            "data" => $role
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
        ]);

        // $uploadedFileUrl = cloudinary()->upload($request->file('poster')->getRealPath(), [
        //     'folder' => 'poster',
        // ])->getSecurePath();

        $role = new Role;

        $role->name = $request->input('name');

        $role->save();

        return response ([
            "message" => "Data berhasil ditambahkan",
            "data" => $role
        ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);

        if(!$role){
            return response ([
                "message" => "data $id tidak ditemukan",
            ],404);
        }

        return response ([
            "message" => "detail role ditampilkan",
            "data" => $role
        ],201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
        ],[

            'required' => 'input :attribute field is required',
        
        ]);

        $role = Role::find($id);
        
        if(!$role){
            return response ([
                "message" => "role tidak ditemukan",
            ], 404);
        }

        $role->name = $request->input('name');

        $role->save();

        return response ([
            "message" => "Data berhasil Diupdate",
        ],200);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        
        $role = Role::find($id);
        if(!$id){
            return response ([
                "message" => "data $id tidak ditemukan",
            ],404);
        }
 
        $role->delete();

        return response ([
            "message" => "Data Detail berhasil Dihapus",
        ],201);
    }
}
