<?php

namespace Tests\Feature\Models;

use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_a_record_with_valid_fields(): void
    {
        $tag = Tag::factory()->create();

        $this->assertNotNull($tag->id);
        $this->assertNotSame('', $tag->name);
        $this->assertMatchesRegularExpression('/^#[0-9a-fA-F]{6}$/', $tag->color);
        $this->assertDatabaseHas('tags', ['id' => $tag->id]);
    }

    public function test_tag_has_many_entries_via_entry_tag_pivot(): void
    {
        $tag = Tag::factory()->create();
        $entries = Entry::factory()->count(2)->create();

        $tag->entries()->attach($entries->pluck('id'));

        $this->assertInstanceOf(BelongsToMany::class, $tag->entries());
        $this->assertCount(2, $tag->entries);
        $this->assertEqualsCanonicalizing(
            $entries->pluck('id')->all(),
            $tag->entries->pluck('id')->all()
        );
    }

    public function test_entry_has_many_tags_via_entry_tag_pivot(): void
    {
        $entry = Entry::factory()->create();
        $tags = Tag::factory()->count(2)->create();

        $entry->tags()->attach($tags->pluck('id'));

        $this->assertInstanceOf(BelongsToMany::class, $entry->tags());
        $this->assertCount(2, $entry->tags);
        $this->assertEqualsCanonicalizing(
            $tags->pluck('id')->all(),
            $entry->tags->pluck('id')->all()
        );
    }

    public function test_attach_creates_a_record_in_entry_tag_pivot_table(): void
    {
        $entry = Entry::factory()->create();
        $tag = Tag::factory()->create();

        $entry->tags()->attach($tag->id);

        $this->assertDatabaseHas('entry_tag', [
            'entry_id' => $entry->id,
            'tag_id' => $tag->id,
        ]);
    }

    public function test_detach_removes_record_from_entry_tag_pivot_table(): void
    {
        $entry = Entry::factory()->create();
        $tag = Tag::factory()->create();

        $entry->tags()->attach($tag->id);
        $entry->tags()->detach($tag->id);

        $this->assertDatabaseMissing('entry_tag', [
            'entry_id' => $entry->id,
            'tag_id' => $tag->id,
        ]);
    }

    public function test_composite_primary_key_prevents_duplicate_entry_tag_pair(): void
    {
        $entry = Entry::factory()->create();
        $tag = Tag::factory()->create();

        $entry->tags()->attach($tag->id);

        $this->expectException(QueryException::class);

        $entry->tags()->attach($tag->id);
    }
}
