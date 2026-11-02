<?php

namespace App\Models;

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
}