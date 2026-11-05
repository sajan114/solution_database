<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTagFilterTest extends TestCase
{
    use RefreshDatabase;

    private Tag $b2b;
    private Tag $free;
    private Tag $scalable;
    private Product $both;
    private Product $onlyB2b;
    private Product $untagged;

    protected function setUp(): void
    {
        parent::setUp();

        $this->b2b = Tag::create(['name' => 'B2B']);
        $this->free = Tag::create(['name' => 'free']);
        $this->scalable = Tag::create(['name' => 'Scalable']);

        $this->both = Product::create(['name' => 'Both']);
        $this->both->tags()->attach([$this->b2b->id, $this->free->id]);

        $this->onlyB2b = Product::create(['name' => 'Only B2B']);
        $this->onlyB2b->tags()->attach([$this->b2b->id]);

        $this->untagged = Product::create(['name' => 'Untagged']);
    }

    public function test_no_tags_returns_all_products(): void
    {
        $this->assertCount(3, Product::withAllTags([])->get());
    }

    public function test_single_tag_returns_products_having_it(): void
    {
        $names = Product::withAllTags([$this->b2b->id])->pluck('name')->sort()->values()->all();

        $this->assertSame(['Both', 'Only B2B'], $names);
    }

    public function test_multiple_tags_require_all_of_them(): void
    {
        $names = Product::withAllTags([$this->b2b->id, $this->free->id])->pluck('name')->all();

        $this->assertSame(['Both'], $names);
    }

    public function test_tag_no_product_has_returns_nothing(): void
    {
        $this->assertCount(0, Product::withAllTags([$this->scalable->id])->get());
    }

    public function test_unknown_tag_id_returns_nothing(): void
    {
        $this->assertCount(0, Product::withAllTags([9999])->get());
    }
}
