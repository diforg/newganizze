<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use SoftDeletes;

    public const NATURES = [
        'income',
        'expense',
    ];

    public const STATUSES = [
        'pending',
        'paid',
        'cancelled',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'description',
        'nature',
        'amount',
        'competence_date',
        'payment_date',
        'account_id',
        'category_id',
        'notes',
        'attachment_url',
        'status',
        'transfer_id',
        'recurrence_id',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'competence_date' => 'date',
            'payment_date' => 'date',
        ];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function recurrence(): BelongsTo
    {
        return $this->belongsTo(Recurrence::class);
    }

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'entry_tag');
    }
}
