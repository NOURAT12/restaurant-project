<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_id',
        'meal_id',
    ];
    public function offer(): BelongsTo
    {
      return $this->belongsTo(Offer::class);

    }
    public function meal(): BelongsTo
    {
      return $this->belongsTo(Meal::class);
    }
    public $appends=['meal'];
    protected $hidden = [
        'meal_id' ,
        'id' ,   
        'offer_id' ,   
        'created_at' ,   
        'updated_at' ,   
       
        ];
    public function getMealAttribute()
    {
      return $this->meal()->first();
    }
}
