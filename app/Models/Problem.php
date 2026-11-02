<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $guarded = [];

    public function solutions()
    {
        return $this->belongsToMany(Solution::class);
    }
}