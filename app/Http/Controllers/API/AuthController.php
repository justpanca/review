<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisterMail;
use App\Mail\GenerateEmailMail;
use App\Models\otpCode;
use Carbon\Carbon;

class AuthController extends Controller 
{
    public function register(Request $request) {
        $request->validate ([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,id',
            'password' => 'required|min:2|confirmed',
            // 'role_id' => 'required|min:2'
        ],[
            'required' => 'inputan :attribute harus diisi',
            'min' => 'inputan :attribute minimal :min karakter',
            'email' => 'inputan :atribute harus bernilai email',
            'unique' => ':unique harus sudah terdaftar',
            'confirmed' => 'inputan password sama dengan konfirmasi password',
        ]);

        $user = new User;

        $roleUser = Role::where('name', 'user')->first();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = $roleUser->id;

        $user->save();

        Mail::to($user->email)->send(new UserRegisterMail($user));

        return response ([
            "message" => "Register berhasil,silahkan cek email",
            "user" => $user,
        ],201);
    }

    public function login(Request $request)
    {
        $request->validate ([
            'email' => 'required',
            'password' => 'required',
        ],[
            'required' => 'inputan :attribute harus diisi',
        ]);

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid user'], 401);
        }

        $user = User::with('role')->where('email',$request->input('email'))->first();

        return response([
            "user" => $user,
            "token" => $token,
        ],200);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json(['message' => 'Logout Berhasil']);
    }

    public function me()
    {
        $user = auth()->user();

        $userData = User::find($user->id)->first();

        return response()->json([
            "message" => "berhasil get user",
            "user" => $userData,
        ]);
    }

    public function generateOtp(Request $request) {
        
        $request->validate ([
            'email' => 'required|email'
        ],[
            'required' => 'inputan :attribute harus diisi',
            'email' => 'inputan harus email'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        $user->generate_otp();

        Mail::to($user->email)->send(new GenerateEmailMail($user));


        return response()->json(
            [
            "success" => "true",
            "message" => "otp code berhasil digenerate,silahkan cek email"
            ]
        );

    }

    public function verifikasi(Request $request) {
        $request->validate ([
            'otp' => 'required|min:6'
        ],[
            'required' => 'inputan :attribute harus diisi',
            'min' => 'inputan maksimal :min karakter'
        ]);

        $user = auth()->user();

        // jika otp tidak ditemukan
        $otp_code = otpCode::where('otp', $request->input('otp'))->where('user_id', $user->id)->first();

        if(!$otp_code){
            return response([
                "response_code" => "01",
                "message" => "otp tidak ditemukan",
            ], 400);
        }

        // jika valid_until expire
        $now = Carbon::now();
        if($now > $otp_code->valid_until) {
            return response([
                "response_code" => "01",
                "message" => "otp sudah kadaluarsa, generate ulang aja",
            ], 400);
        }

        //update
        $user = User::find($otp_code->user_id);

        $user->email_verified_at = $now;

        $user->save();

        $otp_code->delete();

        return response([
            "response_code" => "01",
            "message" => "verifikasi berhasil",
        ], 200);

    }

//     public function update(Request $request)
//     {
  
//     $user = $request->user();

//     $request->validate([
//         'name' => 'string|max:20', 
//         'email' => 'email|max:50|unique:users,email,' . $user->id, 
//     ]);

//     $user->name = $request->name;
//     $user->email = $request->email;
//     $user->save();
//     return response()->json([
//         'message' => 'Profile berhasil diperbarui',
//         'user' => $user
//     ]);
// }


}
