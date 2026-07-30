<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdpObjective extends Model
{
    use HasFactory;

    protected $fillable = [
        'idp_id',
        'development_area',
        'learning_type',
        'scheduling_type',
        'start_month',
        'end_month',
        'specific_months',
        'action_steps',
        'measure_of_success',
        'support_needed',
        'status',
    ];

    protected $casts = [
        'specific_months' => 'array',
    ];

    public function idp()
    {
        return $this->belongsTo(IndividualDevelopmentPlan::class, 'idp_id');
    }
}
