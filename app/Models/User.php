<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'manager_id',
        'role',
        'is_totp_required',
        'two_factor_secret',
        'two_factor_confirmed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_totp_required' => 'boolean',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * هل تم إلزام المستخدم بالمصادقة الثنائية عبر التطبيق من قِبل الإدارة؟
     */
    public function isTotpRequired(): bool
    {
        return (bool) $this->is_totp_required;
    }

    /**
     * هل قام المستخدم بربط جهازه بالتطبيق وتأكيده؟
     */
    public function hasTotpSetup(): bool
    {
        return !empty($this->two_factor_secret) && !is_null($this->two_factor_confirmed_at);
    }

    /**
     * هل المصادقة الثنائية مفعّلة وجاهزة للتحقق عند الدخول؟
     */
    public function hasTotpEnabled(): bool
    {
        return $this->isTotpRequired() && $this->hasTotpSetup();
    }

    /**
     * إعادة تعيين/تصفير إعدادات TOTP للمستخدم (من قبل الأدمن)
     */
    public function resetTotp(): void
    {
        $this->forceFill([
            'two_factor_secret' => null,
            'two_factor_confirmed_at' => null,
        ])->save();
    }

    // Role helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCoach(): bool
    {
        return $this->role === 'coach';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    // Relationships
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    public function swotAnalyses()
    {
        return $this->hasMany(SwotAnalysis::class);
    }

    public function goalsAndKpis()
    {
        return $this->hasMany(GoalAndKpi::class);
    }

    public function criticalIncidents()
    {
        return $this->hasMany(CriticalIncidentLog::class, 'user_id');
    }

    public function reportedIncidents()
    {
        return $this->hasMany(CriticalIncidentLog::class, 'reporter_id');
    }

    public function growSessions()
    {
        return $this->hasMany(GrowSession::class, 'user_id');
    }

    public function coachedSessions()
    {
        return $this->hasMany(GrowSession::class, 'coach_id');
    }

    public function idps()
    {
        return $this->hasMany(IndividualDevelopmentPlan::class, 'user_id');
    }

    public function mentoredIdps()
    {
        return $this->hasMany(IndividualDevelopmentPlan::class, 'mentor_id');
    }

    public function pips()
    {
        return $this->hasMany(PerformanceImprovementPlan::class, 'user_id');
    }
}
