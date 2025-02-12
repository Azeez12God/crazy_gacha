<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Prize extends Model
{
    /** @use HasFactory<\Database\Factories\PrizeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'rarity',
        'reward',
        'image',
        'audio'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot(['prize']);
    }
}
