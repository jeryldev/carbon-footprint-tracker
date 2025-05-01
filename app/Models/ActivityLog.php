<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'transport_type',
        'transport_distance',
        'electricity_usage',
        'waste_generation',
        'carbon_footprint',
    ];

    protected $casts = [
        'date' => 'date',
        'transport_distance' => 'float',
        'electricity_usage' => 'float',
        'waste_generation' => 'float',
        'carbon_footprint' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
