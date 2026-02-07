<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Frazalakon extends Model
{
    protected $fillable = [
        'slug',
        'user_id',
        'group_id',
        'body',
        'who',
        'towho',
        'context',
        'where',
        'when',
        'author',
        'validated_at',
        'public',
        'heart_count',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'frazalakon_likes')->withTimestamps();
    }

    protected function casts(): array
    {
        return [
            'when' => 'datetime',
            'validated_at' => 'datetime',
            'public' => 'boolean',
        ];
    }
}
