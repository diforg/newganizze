<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_a_record_with_valid_fields(): void
    {
        $category = Category::factory()->create();

        $this->assertNotNull($category->id);
        $this->assertNotSame('', $category->name);
        $this->assertContains($category->nature, Category::NATURES);
        $this->assertNotSame('', $category->icon);
        $this->assertMatchesRegularExpression('/^#[0-9a-fA-F]{6}$/', $category->color);
        $this->assertIsBool($category->archived);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_archived_defaults_to_false(): void
    {
        $category = Category::factory()->make();
        unset($category->archived);
        $category->save();

        $this->assertFalse((bool) $category->fresh()->archived);
    }

    public function test_category_can_have_null_parent_category_id_for_root_category(): void
    {
        $category = Category::factory()->create(['parent_category_id' => null]);

        $this->assertNull($category->fresh()->parent_category_id);
    }

    public function test_child_category_belongs_to_parent_category(): void
    {
        $parent = Category::factory()->create();
        $child = Category::factory()->create(['parent_category_id' => $parent->id]);

        $this->assertTrue($child->parent->is($parent));
    }

    public function test_parent_category_has_many_children(): void
    {
        $parent = Category::factory()->create();
        $children = Category::factory()->count(2)->create(['parent_category_id' => $parent->id]);

        $this->assertCount(2, $parent->children);
        $this->assertEqualsCanonicalizing(
            $children->pluck('id')->all(),
            $parent->children->pluck('id')->all()
        );
    }

    public function test_soft_deleted_record_does_not_appear_in_all(): void
    {
        $category = Category::factory()->create();

        $category->delete();

        $this->assertCount(0, Category::all());
    }
}