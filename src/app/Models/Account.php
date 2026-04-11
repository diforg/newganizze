<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    public const TYPES = [
        'checking',
        'savings',
        'wallet',
        'credit_card',
        'investment',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'icon',
        'initial_balance',
        'currency',
        'archived',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'currency' => 'BRL',
        'archived' => false,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'initial_balance' => 'decimal:2',
            'archived' => 'boolean',
        ];
    }

    public function entries(): HasMany
    {
        return $this->hasMany('App\\Models\\Entry');
    }
}
