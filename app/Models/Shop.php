<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
      'name',
      'price',
      'type',
      'quantity',
        'linkImage'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Esta función gestiona la relación entre Tienda y Usuario
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany{
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
