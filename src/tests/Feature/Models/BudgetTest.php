<?php

namespace Tests\Feature\Models;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_a_record_with_valid_fields(): void
    {
        $budget = Budget::factory()->create();

        $this->assertNotNull($budget->id);
        $this->assertNotNull($budget->category_id);
        $this->assertNotNull($budget->limit_amount);
        $this->assertGreaterThanOrEqual(1, $budget->month);
        $this->assertLessThanOrEqual(12, $budget->month);
        $this->assertNotNull($budget->year);
        $this->assertDatabaseHas('budgets', ['id' => $budget->id]);
    }

    public function test_budget_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $budget = Budget::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(BelongsTo::class, $budget->category());
        $this->assertTrue($budget->category->is($category));
    }

    public function test_unique_index_prevents_duplicate_category_month_year_combination(): void
    {
        $category = Category::factory()->create();

        Budget::factory()->create([
            'category_id' => $category->id,
            'month' => 4,
            'year' => 2025,
        ]);

        $this->expectException(QueryException::class);

        Budget::factory()->create([
            'category_id' => $category->id,
            'month' => 4,
            'year' => 2025,
        ]);
    }

    public function test_month_accepts_values_between_one_and_twelve(): void
    {
        $category = Category::factory()->create();

        foreach ([1, 12] as $month) {
            $budget = Budget::factory()->create([
                'category_id' => $category->id,
                'month' => $month,
                'year' => 2025,
            ]);

            $this->assertSame($month, $budget->fresh()->month);
        }
    }

    public function test_year_is_stored_correctly(): void
    {
        $budget = Budget::factory()->create(['year' => 2025]);

        $this->assertSame(2025, $budget->fresh()->year);
    }
}
