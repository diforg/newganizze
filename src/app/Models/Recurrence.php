<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recurrence extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const FREQUENCIES = [
        'daily',
        'weekly',
        'biweekly',
        'monthly',
        'bimonthly',
        'quarterly',
        'semiannual',
        'yearly',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'description',
        'frequency',
        'interval',
        'start_date',
        'end_date',
        'total_installments',
        'current_installment',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'interval' => 'integer',
        ];
    }

    public function entries(): HasMany
    {
        return $this->hasMany('App\\Models\\Entry');
    }
}