<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceImprovementPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gap_description',
        'strict_targets',
        'management_support',
        'start_date',
        'end_date',
        'status',
        'employee_signed',
        'manager_signed',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'employee_signed' => 'boolean',
        'manager_signed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
