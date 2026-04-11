<?php

namespace Tests\Feature\Models;

use App\Models\Entry;
use App\Models\Recurrence;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecurrenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_a_record_with_valid_fields(): void
    {
        $recurrence = Recurrence::factory()->create();

        $this->assertNotNull($recurrence->id);
        $this->assertNotSame('', $recurrence->description);
        $this->assertContains($recurrence->frequency, Recurrence::FREQUENCIES);
        $this->assertNotNull($recurrence->interval);
        $this->assertNotNull($recurrence->start_date);
        $this->assertDatabaseHas('recurrences', ['id' => $recurrence->id]);
    }

    public function test_interval_defaults_to_one(): void
    {
        $recurrence = Recurrence::factory()->make();
        unset($recurrence->interval);
        $recurrence->save();

        $this->assertSame(1, $recurrence->fresh()->interval);
    }

    public function test_end_date_accepts_null(): void
    {
        $recurrence = Recurrence::factory()->create(['end_date' => null]);

        $this->assertNull($recurrence->fresh()->end_date);
    }

    public function test_total_installments_accepts_null(): void
    {
        $recurrence = Recurrence::factory()->create([
            'total_installments' => null,
            'current_installment' => null,
        ]);

        $this->assertNull($recurrence->fresh()->total_installments);
    }

    public function test_recurrence_has_many_entries(): void
    {
        $recurrence = Recurrence::factory()->create();
        $entry = Entry::factory()->create(['recurrence_id' => $recurrence->id]);

        $this->assertInstanceOf(HasMany::class, $recurrence->entries());
        $this->assertTrue($recurrence->entries->first()->is($entry));
    }

    public function test_deleting_recurrence_sets_recurrence_id_to_null_on_entries_due_to_fk_null_on_delete(): void
    {
        $recurrence = Recurrence::factory()->create();
        $entry = Entry::factory()->create(['recurrence_id' => $recurrence->id]);

        $recurrence->forceDelete();

        $this->assertNull($entry->fresh()->recurrence_id);
    }

    public function test_soft_deleted_record_does_not_appear_in_all(): void
    {
        $recurrence = Recurrence::factory()->create();

        $recurrence->delete();

        $this->assertCount(0, Recurrence::all());
    }

    public function test_soft_deleted_record_appears_with_trashed(): void
    {
        $recurrence = Recurrence::factory()->create();

        $recurrence->delete();

        $this->assertCount(1, Recurrence::withTrashed()->get());
        $this->assertNotNull(Recurrence::withTrashed()->find($recurrence->id));
    }
}
