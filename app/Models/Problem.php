<?php

namespace App\Models;

use App\Models\Concerns\Searchable;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use Searchable;

    protected $guarded = [];

    public function solutions()
    {
        return $this->belongsToMany(Solution::class);
    }
}
