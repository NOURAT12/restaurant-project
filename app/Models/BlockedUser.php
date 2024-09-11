<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockedUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];
    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class);
    }
    public $appends=['users'];
    protected $hidden = [
        'user_id' ,
        'created_at' ,   
        'updated_at' 
    ];
  
    public function getUsersAttribute()
    {
      return $this->user;
    }
}
