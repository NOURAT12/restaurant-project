<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'rustaurant_id',
        'additional_details',
        'state',
    ];

    public function order_items(): HasMany
    {
      return $this->hasMany(OrderItem::class);
    }

    public function order_offers(): HasMany
    {
      return $this->hasMany(OrderOffer::class);
    }

    public $appends=['total_price','order_item','order_offer'];
    protected $hidden = [
       'order_items',
       'order_offers',
   ];
    public function getOrderItemAttribute()
    {
      return $this->order_items;
    }
    public function getOrderOfferAttribute()
    {
      return $this->order_offers;
    }
    public function getTotalPriceAttribute()
    {
        $price=0;
        for ($i=0; $i < count($this->order_items); $i++) { 
          $price+=  $this->order_items[$i]->meal->price;
        }
        for ($i=0; $i < count($this->order_offers); $i++) { 
          $price+=  $this->order_offers[$i]->offer->new_price;
        }
      return $price;
    }
}
