<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rusturant extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'phone',
        'location',
        'status',
        'service_id',
        'manager_id',
        'table_number',
        'description',
        'name',
    ];

    public function rus_rates(): HasMany
    {
      return $this->hasMany(RusRate::class);

    }

    public $appends=['rate','numberUserRate'];

    protected $hidden = [
      'rus_rates'
      ];
  public function getNumberUserRateAttribute():float
  {
    return count($this->rus_rates);
  }


    public function getRateAttribute():float
    {
          $rate=0;
          for ($i=0; $i < count($this->rus_rates) ; $i++) {
            $rate+=$this->rus_rates[$i]->percent;
          }
         if($rate==0) {
            return $rate;
        }
        return $rate/count($this->rus_rates);
    }
}
