<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabel extends Model
{
    use HasFactory;
    protected $fillable = [
        'table_number',
        'floor_number',
        'rustaurant_id',
        'chairs_number',
        'state',
    ];
}
