<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'image',
        'rustaurant_id',
        'state',
        'new_price',
        'old_price',
    ];


    public function offer_items(): HasMany
    {
      return $this->hasMany(OfferItem::class);
    }
 public $appends=['offer_item'];
 protected $hidden = [
    'offer_items',
];
 public function getOfferItemAttribute()
 {
   return $this->offer_items;
 }
}
