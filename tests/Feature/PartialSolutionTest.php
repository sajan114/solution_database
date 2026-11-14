<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Solution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartialSolutionTest extends TestCase
{
    use RefreshDatabase;

    private function linkedProduct(bool $partial = false): array
    {
        $solution = Solution::create(['name' => 'Webstore']);
        $product = Product::create(['name' => 'FreeCart']);
        $solution->products()->attach($product->id, ['is_partial' => $partial]);

        return [$solution, $product];
    }

    public function test_a_product_is_a_full_solution_by_default(): void
    {
        $solution = Solution::create(['name' => 'Webstore']);
        $product = Product::create(['name' => 'ShopEasy']);
        $solution->products()->attach($product->id);

        $this->assertFalse((bool) $solution->products()->first()->pivot->is_partial);
    }

    public function test_toggle_marks_a_product_as_partial_and_back(): void
    {
        [$solution, $product] = $this->linkedProduct(false);
        $url = "/solutions/{$solution->id}/products/{$product->id}/partial";

        $this->patch($url)->assertRedirect();
        $this->assertTrue((bool) $solution->products()->first()->pivot->is_partial);

        $this->patch($url)->assertRedirect();
        $this->assertFalse((bool) $solution->products()->first()->pivot->is_partial);
    }

    public function test_toggle_returns_404_when_the_product_is_not_linked_to_the_solution(): void
    {
        $solution = Solution::create(['name' => 'Webstore']);
        $other = Product::create(['name' => 'Unrelated']);

        $this->patch("/solutions/{$solution->id}/products/{$other->id}/partial")->assertNotFound();
    }

    public function test_solution_page_labels_partial_products(): void
    {
        [$solution] = $this->linkedProduct(true);

        $this->get("/solutions/{$solution->id}")
            ->assertOk()
            ->assertSee('Partial solution')
            ->assertSee('Mark as full solution');
    }

    public function test_solution_page_does_not_label_full_products_as_partial(): void
    {
        [$solution] = $this->linkedProduct(false);

        $this->get("/solutions/{$solution->id}")
            ->assertOk()
            ->assertDontSee('Partial solution')
            ->assertSee('Mark as partial');
    }
}
