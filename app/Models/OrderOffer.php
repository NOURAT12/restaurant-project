<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderOffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_id',
        'order_id',
    ];

    public function offer(): BelongsTo
    {
      return $this->belongsTo(Offer::class);

    }
    public function order(): BelongsTo
    {
      return $this->belongsTo(Order::class);

    }

    public $appends=['offer'];
    protected $hidden = [
        'offer_id' ,
        'id' ,   
        'order_id' ,   
        'created_at' ,   
        'updated_at' ,   
       
        ];
    public function getOfferAttribute()
    {
      return $this->offer()->first();
    }
}
