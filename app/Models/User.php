<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject 
{
    use HasFactory,HasApiTokens, HasUuids, Notifiable;

    protected $table = 'users';

    protected $fillable = ['name','email','password','role_id'];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function getJWTIdentifier() {
    {
        return $this->getKey();
    }
    }

    public function otpdata()
    {
        return $this->hasOne(otpCode::class, 'user_id');
    }



    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function boot() {
        parent::boot();

        static::created(function($model){
            $model->generate_otp();
        });
    }

    public function generate_otp() {
        do {
            $randomNumber = mt_rand(100000, 999999);
            $check = otpCode::where('otp', $randomNumber)->first();
        }   while($check);

        $now = Carbon::now();

        $otp_code = otpCode::updateOrCreate(
            ['user_id' => $this->id],
        [
            'otp' => $randomNumber,
            'valid_until' => $now->addMinutes(5)
           
        ]);
    }
}
