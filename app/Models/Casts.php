<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Casts extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'casts';

    protected $fillable = ['name','age','bio'];

    public function review()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function CastMovie()
    {
        return $this->hasMany(CastMovie::class, 'movie_id');
    }

    public function list_movies()
    {
        return $this->belongsToMany(Movie::class, 'cast_movies','cast_id','movie_id');
    }
    
}
