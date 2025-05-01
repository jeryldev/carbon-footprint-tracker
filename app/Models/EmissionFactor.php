<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionFactor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category',
        'type',
        'value',
        'unit',
        'description',
        'source_reference',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'float',
    ];

    /**
     * Get emission factor value by category and type.
     *
     * @param string $category
     * @param string $type
     * @return float|null
     */
    public static function getFactorValue(string $category, string $type): ?float
    {
        return self::where('category', $category)
            ->where('type', $type)
            ->value('value');
    }

    /**
     * Get all factors for a specific category.
     *
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getFactorsByCategory(string $category)
    {
        return self::where('category', $category)->get();
    }

    /**
     * Get all available transport types with friendly labels.
     *
     * @return array
     */
    public static function getTransportTypes(): array
    {
        $types = self::where('category', 'transportation')
            ->pluck('type')
            ->toArray();

        $labels = [
            'walk' => 'Walking',
            'bicycle' => 'Bicycle',
            'motorcycle' => 'Motorcycle',
            'car' => 'Car',
            'public_transit' => 'Public Transit (Bus, Jeepney, etc.)',
        ];

        $result = [];
        foreach ($types as $type) {
            $result[$type] = $labels[$type] ?? ucfirst(str_replace('_', ' ', $type));
        }

        return $result;
    }
}
