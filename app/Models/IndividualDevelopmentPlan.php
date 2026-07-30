<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualDevelopmentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mentor_id',
        'career_goal',
        'start_date',
        'end_date',
        'duration_in_months',
        'status',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->start_date && $model->end_date) {
                $start = \Carbon\Carbon::parse($model->start_date);
                $end = \Carbon\Carbon::parse($model->end_date);
                $model->duration_in_months = max(1, $start->diffInMonths($end));
            }
        });
    }

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function objectives()
    {
        return $this->hasMany(IdpObjective::class, 'idp_id');
    }
}
