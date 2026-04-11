<?php

namespace Tests\Feature\Models;

use App\Models\Entry;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_a_record_with_valid_fields(): void
    {
        $transfer = Transfer::factory()->create();

        $this->assertNotNull($transfer->id);
        $this->assertNotNull($transfer->origin_entry_id);
        $this->assertNotNull($transfer->destination_entry_id);
        $this->assertNotNull($transfer->conversion_rate);
        $this->assertDatabaseHas('transfers', ['id' => $transfer->id]);
    }

    public function test_conversion_rate_defaults_to_one(): void
    {
        $transfer = Transfer::factory()->make();
        unset($transfer->conversion_rate);
        $transfer->save();

        $this->assertSame('1.000000', $transfer->fresh()->conversion_rate);
    }

    public function test_notes_accepts_null(): void
    {
        $transfer = Transfer::factory()->create(['notes' => null]);

        $this->assertNull($transfer->fresh()->notes);
    }

    public function test_transfer_belongs_to_origin_entry(): void
    {
        $originEntry = Entry::factory()->create();
        $transfer = Transfer::factory()->create(['origin_entry_id' => $originEntry->id]);

        $this->assertInstanceOf(BelongsTo::class, $transfer->originEntry());
        $this->assertTrue($transfer->originEntry->is($originEntry));
    }

    public function test_transfer_belongs_to_destination_entry(): void
    {
        $destinationEntry = Entry::factory()->create();
        $transfer = Transfer::factory()->create(['destination_entry_id' => $destinationEntry->id]);

        $this->assertInstanceOf(BelongsTo::class, $transfer->destinationEntry());
        $this->assertTrue($transfer->destinationEntry->is($destinationEntry));
    }

    public function test_deleting_entry_linked_to_transfer_throws_exception_due_to_restrict_fk(): void
    {
        $transfer = Transfer::factory()->create();

        $this->expectException(QueryException::class);

        $transfer->originEntry->forceDelete();
    }
}
