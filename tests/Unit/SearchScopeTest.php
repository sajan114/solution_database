<?php

namespace Tests\Unit;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchScopeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Problem::create(['name' => 'Enhancing company brand', 'description' => 'Nobody knows about us']);
        Problem::create(['name' => 'Reaching new clients', 'description' => null]);
        Problem::create(['name' => 'Improving internal processes', 'description' => 'Billing takes too long']);
    }

    public function test_blank_term_returns_everything(): void
    {
        $this->assertCount(3, Problem::search('')->get());
        $this->assertCount(3, Problem::search('   ')->get());
        $this->assertCount(3, Problem::search(null)->get());
    }

    public function test_matches_the_name(): void
    {
        $this->assertSame(['Reaching new clients'], Problem::search('clients')->pluck('name')->all());
    }

    public function test_matches_the_description(): void
    {
        $this->assertSame(['Improving internal processes'], Problem::search('billing')->pluck('name')->all());
    }

    public function test_is_not_case_sensitive(): void
    {
        $this->assertCount(1, Problem::search('BRAND')->get());
    }

    public function test_surrounding_spaces_are_ignored(): void
    {
        $this->assertCount(1, Problem::search('  brand  ')->get());
    }

    public function test_no_match_returns_nothing(): void
    {
        $this->assertCount(0, Problem::search('zebra')->get());
    }

    public function test_solutions_can_be_searched_too(): void
    {
        Solution::create(['name' => 'Webstore', 'description' => 'Sell online']);
        Solution::create(['name' => 'Social media presence']);

        $this->assertSame(['Webstore'], Solution::search('online')->pluck('name')->all());
        $this->assertSame(['Social media presence'], Solution::search('social')->pluck('name')->all());
    }
}
