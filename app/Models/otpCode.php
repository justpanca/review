<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class otpCode extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'otp_codes';

    protected $fillable = ['otp', 'user_id','poster','valid_until'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
