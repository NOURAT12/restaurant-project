<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'meal_id',
        'order_id',
    ];
    public function meal(): BelongsTo
    {
      return $this->belongsTo(Meal::class);
    }
    public function order(): BelongsTo
    {
      return $this->belongsTo(Order::class);

    }

    public $appends=['meal'];
    protected $hidden = [
        'meal_id' ,
        'id' ,
        'order_id' ,
        'created_at' ,
        'updated_at' ,

        ];
    public function getMealAttribute()
    {
      return $this->meal()->first();
    }
}
