<?php

namespace Tests\Feature;

use App\Models\Problem;
use App\Models\Product;
use App\Models\Solution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_problem_list_shows_everything_without_a_search(): void
    {
        Problem::create(['name' => 'Enhancing company brand']);
        Problem::create(['name' => 'Reaching new clients']);

        $this->get('/')->assertOk()->assertSee('Enhancing company brand')->assertSee('Reaching new clients');
    }

    public function test_problem_search_filters_the_list_and_keeps_the_term(): void
    {
        Problem::create(['name' => 'Enhancing company brand']);
        Problem::create(['name' => 'Reaching new clients']);

        $this->get('/?q=brand')
            ->assertOk()
            ->assertSee('Enhancing company brand')
            ->assertDontSee('Reaching new clients')
            ->assertSee('value="brand"', false)
            ->assertSee('1 problem found for');
    }

    public function test_problem_search_with_no_match_says_so(): void
    {
        Problem::create(['name' => 'Enhancing company brand']);

        $this->get('/?q=zebra')->assertOk()->assertSee('No problems match');
    }

    public function test_solutions_page_lists_solutions_with_counts(): void
    {
        $solution = Solution::create(['name' => 'Webstore']);
        $solution->products()->attach(Product::create(['name' => 'ShopEasy'])->id);
        $solution->problems()->attach(Problem::create(['name' => 'Reaching new clients'])->id);

        $this->get('/solutions')
            ->assertOk()
            ->assertSee('Webstore')
            ->assertSee('1 problem')
            ->assertSee('1 product');
    }

    public function test_solution_search_filters_the_list(): void
    {
        Solution::create(['name' => 'Webstore', 'description' => 'Sell online']);
        Solution::create(['name' => 'Social media presence']);

        $this->get('/solutions?q=online')
            ->assertOk()
            ->assertSee('Webstore')
            ->assertDontSee('Social media presence');
    }

    public function test_search_term_is_escaped_in_the_page(): void
    {
        $this->get('/?q=' . urlencode('<script>alert(1)</script>'))
            ->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false);
    }
}
