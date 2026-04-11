<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Category;
use App\Models\Entry;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_a_record_with_valid_fields(): void
    {
        $entry = Entry::factory()->create();

        $this->assertNotNull($entry->id);
        $this->assertNotSame('', $entry->description);
        $this->assertContains($entry->nature, Entry::NATURES);
        $this->assertNotNull($entry->amount);
        $this->assertNotNull($entry->competence_date);
        $this->assertContains($entry->status, Entry::STATUSES);
        $this->assertNotNull($entry->account_id);
        $this->assertDatabaseHas('entries', ['id' => $entry->id]);
    }

    public function test_status_defaults_to_pending(): void
    {
        $entry = Entry::factory()->make();
        unset($entry->status);
        $entry->save();

        $this->assertSame('pending', $entry->fresh()->status);
    }

    public function test_category_id_accepts_null(): void
    {
        $entry = Entry::factory()->create(['category_id' => null]);

        $this->assertNull($entry->fresh()->category_id);
    }

    public function test_payment_date_accepts_null(): void
    {
        $entry = Entry::factory()->create(['payment_date' => null]);

        $this->assertNull($entry->fresh()->payment_date);
    }

    public function test_transfer_id_accepts_null(): void
    {
        $entry = Entry::factory()->create(['transfer_id' => null]);

        $this->assertNull($entry->fresh()->transfer_id);
    }

    public function test_recurrence_id_accepts_null(): void
    {
        $entry = Entry::factory()->create(['recurrence_id' => null]);

        $this->assertNull($entry->fresh()->recurrence_id);
    }

    public function test_entry_belongs_to_account(): void
    {
        $account = Account::factory()->create();
        $entry = Entry::factory()->create(['account_id' => $account->id]);

        $this->assertInstanceOf(BelongsTo::class, $entry->account());
        $this->assertTrue($entry->account->is($account));
    }

    public function test_entry_belongs_to_category_and_category_is_nullable(): void
    {
        $category = Category::factory()->create();
        $entryWithCategory = Entry::factory()->create(['category_id' => $category->id]);
        $entryWithoutCategory = Entry::factory()->create(['category_id' => null]);

        $this->assertInstanceOf(BelongsTo::class, $entryWithCategory->category());
        $this->assertTrue($entryWithCategory->category->is($category));
        $this->assertNull($entryWithoutCategory->fresh()->category);
    }

    public function test_soft_deleted_record_does_not_appear_in_all(): void
    {
        $entry = Entry::factory()->create();

        $entry->delete();

        $this->assertCount(0, Entry::all());
    }

    public function test_soft_deleted_record_appears_with_trashed(): void
    {
        $entry = Entry::factory()->create();

        $entry->delete();

        $this->assertCount(1, Entry::withTrashed()->get());
        $this->assertNotNull(Entry::withTrashed()->find($entry->id));
    }

    public function test_deleting_account_with_entries_throws_exception_due_to_restrict_fk(): void
    {
        $account = Account::factory()->create();
        Entry::factory()->create(['account_id' => $account->id]);

        $this->expectException(QueryException::class);

        $account->forceDelete();
    }

    public function test_deleting_category_sets_category_id_to_null_due_to_fk_null_on_delete(): void
    {
        $category = Category::factory()->create();
        $entry = Entry::factory()->create(['category_id' => $category->id]);

        $category->forceDelete();

        $this->assertNull($entry->fresh()->category_id);
    }

    public function test_query_filtering_by_account_id_and_competence_date_executes_without_error(): void
    {
        $entry = Entry::factory()->create();

        $results = Entry::query()
            ->where('account_id', $entry->account_id)
            ->whereDate('competence_date', $entry->competence_date)
            ->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->first()->is($entry));
    }
}