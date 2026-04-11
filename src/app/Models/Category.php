<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const NATURES = [
        'income',
        'expense',
        'both',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nature',
        'icon',
        'color',
        'parent_category_id',
        'archived',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'archived' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany('App\\Models\\Entry');
    }

    public function budgets(): HasMany
    {
        return $this->hasMany('App\\Models\\Budget');
    }
}
