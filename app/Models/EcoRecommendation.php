<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcoRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'tip',
        'impact_description',
        'potential_savings'
    ];
}
