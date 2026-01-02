<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GolfCourse extends Model
{
    protected $fillable = [
        'name',
        'city',
        'province',
    ];

    public function golfRounds()
    {
        return $this->hasMany(GolfRound::class);
    }
}
