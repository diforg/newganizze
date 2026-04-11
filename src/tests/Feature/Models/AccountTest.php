<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_a_record_with_valid_fields(): void
    {
        $account = Account::factory()->create();

        $this->assertNotNull($account->id);
        $this->assertNotSame('', $account->name);
        $this->assertContains($account->type, Account::TYPES);
        $this->assertNotSame('', $account->icon);
        $this->assertNotNull($account->initial_balance);
        $this->assertSame(3, strlen($account->currency));
        $this->assertIsBool($account->archived);
        $this->assertDatabaseHas('accounts', ['id' => $account->id]);
    }

    public function test_archived_defaults_to_false(): void
    {
        $account = Account::factory()->make();
        unset($account->archived);
        $account->save();

        $this->assertFalse((bool) $account->fresh()->archived);
    }

    public function test_currency_defaults_to_brl(): void
    {
        $account = Account::factory()->make();
        unset($account->currency);
        $account->save();

        $this->assertSame('BRL', $account->fresh()->currency);
    }

    public function test_soft_deleted_record_does_not_appear_in_all(): void
    {
        $account = Account::factory()->create();

        $account->delete();

        $this->assertCount(0, Account::all());
    }

    public function test_soft_deleted_record_appears_with_trashed(): void
    {
        $account = Account::factory()->create();

        $account->delete();

        $this->assertCount(1, Account::withTrashed()->get());
        $this->assertNotNull(Account::withTrashed()->find($account->id));
    }
}