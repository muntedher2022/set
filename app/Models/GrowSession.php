<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrowSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coach_id',
        'session_date',
        'goal',
        'reality',
        'options',
        'way_forward',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
