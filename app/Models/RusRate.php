<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RusRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'rusturant_id',
        'user_id',
        'percent',
    ];
    public function rusturant(): BelongsTo
    {
      return $this->belongsTo(Rusturant::class);

    }
}
