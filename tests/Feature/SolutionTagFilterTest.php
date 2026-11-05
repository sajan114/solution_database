<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Solution;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolutionTagFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_solution_page_filters_products_by_selected_tags(): void
    {
        $solution = Solution::create(['name' => 'Webstore']);
        $b2b = Tag::create(['name' => 'B2B']);
        $b2c = Tag::create(['name' => 'B2C']);

        $a = Product::create(['name' => 'Alpha']);
        $b = Product::create(['name' => 'Beta']);
        $solution->products()->attach([$a->id, $b->id]);
        $a->tags()->attach($b2b->id);
        $b->tags()->attach($b2c->id);

        $this->get("/solutions/{$solution->id}?tags[]={$b2b->id}")
            ->assertOk()
            ->assertSee('Alpha')
            ->assertDontSee('Beta (');

        $this->get("/solutions/{$solution->id}")
            ->assertOk()
            ->assertSee('Alpha')
            ->assertSee('Beta');
    }
}
