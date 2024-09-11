<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'meal_id',
        'user_id',
        'percent',
    ];

    public function meal():BelongsTo
    {
      return $this->belongsTo(Meals::class);

    }
}
