<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory;

    protected $fillable = [
      'name',
      'price',
      'type',
      'quantity'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function users(): BelongsToMany{
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
