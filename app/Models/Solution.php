<?php

namespace App\Models;

use App\Models\Concerns\Searchable;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use Searchable;

    protected $guarded = [];

    public function problems()
    {
        return $this->belongsToMany(Problem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('is_partial');
    }
}