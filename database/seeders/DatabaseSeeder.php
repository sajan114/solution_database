<?php

namespace Database\Seeders;

use App\Models\Problem;
use App\Models\Product;
use App\Models\Solution;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tags
        $b2b   = Tag::create(['name' => 'B2B']);
        $b2c   = Tag::create(['name' => 'B2C']);
        $free  = Tag::create(['name' => 'free']);
        $scale = Tag::create(['name' => 'Scalable']);

        // Problems
        $clients = Problem::create(['name' => 'Reaching new clients']);
        $brand   = Problem::create(['name' => 'Enhancing company brand']);
        Problem::create(['name' => 'Improving internal processes']);

        // Solutions
        $webstore = Solution::create(['name' => 'Webstore']);
        $social   = Solution::create(['name' => 'Social media presence']);
        $crm      = Solution::create(['name' => 'Customer relationship management']);

        // Problem <-> Solution links
        $clients->solutions()->attach([$webstore->id, $social->id, $crm->id]);
        $brand->solutions()->attach([$social->id]);

        // Products
        $p1 = Product::create(['name' => 'ShopEasy', 'vendor' => 'Demo Oy']);
        $p2 = Product::create(['name' => 'B2B Commerce Pro', 'vendor' => 'Demo Ltd']);
        $p3 = Product::create(['name' => 'FreeCart', 'vendor' => 'Open Inc']);

        $webstore->products()->attach([$p1->id, $p2->id, $p3->id]);

        // Product <-> Tag links
        $p1->tags()->attach([$b2c->id, $scale->id]);
        $p2->tags()->attach([$b2b->id, $scale->id]);
        $p3->tags()->attach([$free->id, $b2c->id]);
    }
}