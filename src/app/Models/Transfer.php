<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transfer extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'origin_entry_id',
        'destination_entry_id',
        'conversion_rate',
        'notes',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'conversion_rate' => '1.000000',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'conversion_rate' => 'decimal:6',
        ];
    }

    public function originEntry(): BelongsTo
    {
        return $this->belongsTo('App\\Models\\Entry', 'origin_entry_id');
    }

    public function destinationEntry(): BelongsTo
    {
        return $this->belongsTo('App\\Models\\Entry', 'destination_entry_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany('App\\Models\\Entry', 'transfer_id');
    }
}
