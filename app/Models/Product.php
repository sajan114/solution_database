<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function solutions()
    {
        return $this->belongsToMany(Solution::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Keep only products that have ALL of the given tags (AND logic).
     * An empty list leaves the query unchanged.
     */
    public function scopeWithAllTags(Builder $query, array $tagIds): Builder
    {
        foreach (array_unique(array_filter($tagIds)) as $tagId) {
            $query->whereHas('tags', fn ($tags) => $tags->whereKey($tagId));
        }

        return $query;
    }
}
