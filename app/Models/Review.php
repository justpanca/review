<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Support\Str;

class Review extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'reviews';

    protected $fillable = ['critic','rating','user_id','movie_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function cast()
    {
        return $this->belongsTo(Casts::class, 'user_id');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($review) {
    //         if (empty($review->id)) {
    //             $review->id = (string) Str::uuid();  
    //         }
    //     });
    // }
}
