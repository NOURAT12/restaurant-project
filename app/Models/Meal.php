<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Node\Expr\Cast\Double;

class Meal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'category_id',
        'rustaurant_id',
        'price',
        'menu',
    ];

    public function meal_rates():HasMany
    {
      return $this->hasMany(MealRate::class);

    }
    public function offer_items():HasMany
    {
      return $this->hasMany(OfferItem::class);

    }
    public function order_items():HasMany
    {
      return $this->hasMany(OrderItem::class);

    }

  public $appends=['rate','numberUserRate'];
  protected $hidden = [
'meal_rates' 
];

  public function getNumberUserRateAttribute():float
  {
    return count($this->meal_rates);
  }


    public function getRateAttribute():float
    {
          $rate=0;
          for ($i=0; $i < count($this->meal_rates) ; $i++) { 
            $rate+=$this->meal_rates[$i]->percent;
          }

           if($rate==0) 
        return $rate;
        return $rate/count($this->meal_rates);
    }
}
