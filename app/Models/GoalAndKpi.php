<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalAndKpi extends Model
{
    use HasFactory;

    protected $table = 'goals_and_kpis';

    protected $fillable = [
        'user_id',
        'perspective',
        'smart_goal_text',
        'weight',
        'baseline',
        'target',
        'current_progress_rate',
        'kpi_type',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'baseline' => 'decimal:2',
        'target' => 'decimal:2',
        'current_progress_rate' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
