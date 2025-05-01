<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the baseline assessment associated with the user.
     *
     * @return HasOne<BaselineAssessment>
     */
    public function baselineAssessment(): HasOne
    {
        return $this->hasOne(BaselineAssessment::class);
    }

    /**
     * Get or create the user's baseline assessment.
     * If the baseline assessment doesn't exist, creates one with default values.
     *
     * @return BaselineAssessment
     */
    public function getOrCreateBaselineAssessment(): BaselineAssessment
    {
        if (!$this->baselineAssessment) {
            return $this->baselineAssessment()->create([
                'commute_days_per_week' => 5, // Default to 5 days per week
            ]);
        }
        return $this->baselineAssessment;
    }

    /**
     * Check if the user has completed their baseline assessment.
     * Returns true if the baseline assessment exists and has a carbon footprint calculated.
     *
     * @return bool
     */
    public function hasCompletedBaselineAssessment(): bool
    {
        return $this->baselineAssessment && $this->baselineAssessment->baseline_carbon_footprint !== null;
    }

    /**
     * Get all activity logs associated with the user.
     * This relation retrieves the user's carbon footprint activity history.
     *
     * @return HasMany<ActivityLog>
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    // In app/Models/User.php

    // Add this to the existing relationships
    /**
     * Get the user's achievements.
     */
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
