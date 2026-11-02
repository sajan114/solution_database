<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    protected $guarded = [];

    public function problems()
    {
        return $this->belongsToMany(Problem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}