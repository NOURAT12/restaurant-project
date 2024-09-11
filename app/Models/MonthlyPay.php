<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPay extends Model
{
    use HasFactory;
    protected $fillable = [
        'is_paid',
        'cost',
        'rustaurant_id',
        'end',
        'start',
    ];
}
