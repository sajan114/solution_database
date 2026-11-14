<?php

namespace Tests\Feature;

use App\Models\Problem;
use App\Models\Product;
use App\Models\Solution;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    use RefreshDatabase;

    private Solution $solution;
    private Tag $b2b;

    protected function setUp(): void
    {
        parent::setUp();

        $this->solution = Solution::create(['name' => 'Webstore']);
        $this->b2b = Tag::create(['name' => 'B2B']);

        $tagged = Product::create(['name' => 'Tagged']);
        $plain = Product::create(['name' => 'Plain']);
        $this->solution->products()->attach([$tagged->id, $plain->id]);
        $tagged->tags()->attach($this->b2b->id);
    }

    public function test_a_valid_tag_filter_works_and_shows_no_error(): void
    {
        $this->get("/solutions/{$this->solution->id}?tags[]={$this->b2b->id}")
            ->assertOk()
            ->assertSee('Tagged')
            ->assertDontSee('Plain')
            ->assertDontSee('class="errors"', false);
    }

    public function test_a_non_numeric_tag_is_rejected_and_everything_is_shown(): void
    {
        $this->get("/solutions/{$this->solution->id}?tags[]=abc")
            ->assertOk()
            ->assertSee('Each selected tag must be a number.')
            ->assertSee('Tagged')
            ->assertSee('Plain');
    }

    public function test_a_tag_that_does_not_exist_is_rejected(): void
    {
        $this->get("/solutions/{$this->solution->id}?tags[]=9999")
            ->assertOk()
            ->assertSee('One of the selected tags does not exist.')
            ->assertSee('Plain');
    }

    public function test_tags_must_be_a_list(): void
    {
        $this->get("/solutions/{$this->solution->id}?tags=abc")
            ->assertOk()
            ->assertSee('The tag filter is not valid.')
            ->assertSee('Plain');
    }

    public function test_too_many_tags_are_rejected(): void
    {
        $query = collect(range(1, 21))->map(fn ($i) => "tags[]={$this->b2b->id}")->implode('&');

        $this->get("/solutions/{$this->solution->id}?{$query}")
            ->assertOk()
            ->assertSee('You can filter by at most 20 tags.');
    }

    public function test_an_overlong_problem_search_is_rejected_and_the_list_is_still_shown(): void
    {
        Problem::create(['name' => 'Reaching new clients']);

        $this->get('/?q=' . str_repeat('a', 101))
            ->assertOk()
            ->assertSee('The search can be at most 100 characters long.')
            ->assertSee('Reaching new clients');
    }

    public function test_an_array_as_search_term_is_rejected(): void
    {
        $this->get('/solutions?q[]=x')
            ->assertOk()
            ->assertSee('The search must be plain text.')
            ->assertSee('Webstore');
    }

    public function test_an_overlong_solution_search_is_rejected(): void
    {
        $this->get('/solutions?q=' . str_repeat('a', 101))
            ->assertOk()
            ->assertSee('The search can be at most 100 characters long.');
    }

    public function test_problem_description_has_a_length_limit(): void
    {
        $this->post('/problems', ['name' => 'Valid name', 'description' => str_repeat('x', 5001)])
            ->assertSessionHasErrors('description');

        $this->assertSame(0, Problem::count());
    }

    public function test_problem_name_must_be_text(): void
    {
        $this->post('/problems', ['name' => ['not', 'text']])->assertSessionHasErrors('name');
        $this->post('/problems', ['name' => ''])->assertSessionHasErrors('name');
    }

    public function test_a_valid_problem_is_saved(): void
    {
        $this->post('/problems', ['name' => 'Valid name', 'description' => 'Fine'])->assertRedirect('/');

        $this->assertSame(1, Problem::count());
    }
}
