<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

// Adds ->search('words') to models that have a name and a description column.
trait Searchable
{
    /**
     * Keep rows whose name or description contains the term.
     * A blank term leaves the query unchanged.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        $like = '%' . $term . '%';

        return $query->where(function (Builder $q) use ($like) {
            $q->where('name', 'like', $like)->orWhere('description', 'like', $like);
        });
    }
}
