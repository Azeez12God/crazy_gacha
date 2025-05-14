<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 */
class Prize extends Model
{
    /** @use HasFactory<\Database\Factories\PrizeFactory> */
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'rarity',
        'reward',
        'image',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Esta función gestiona la relación entre Premios y Usuarios
     *
     * @return BelongsToMany
     */
    public function users():BelongsToMany{
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot(['prize']);
    }
}
