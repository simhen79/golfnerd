<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GolfRound extends Model
{
    protected $fillable = [
        'user_id',
        'golf_course_id',
        'date_played',
        'eagles',
        'birdies',
        'putts',
        'bogeys',
        'double_bogeys_or_worse',
        'score',
    ];

    protected $casts = [
        'date_played' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function golfCourse(): BelongsTo
    {
        return $this->belongsTo(GolfCourse::class);
    }
}
