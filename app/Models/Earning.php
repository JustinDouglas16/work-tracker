<?php

namespace App\Models;

use Database\Factories\EarningFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Earning extends Model
{
    /** @use HasFactory<EarningFactory> */
    use HasFactory;

    protected $attributes = [
        'currency' => 'SRD',
    ];

    protected $fillable = [
        'user_id',
        'pay_date',
        'base_amount',
        'bonus_amount',
        'overtime_pay_amount',
        'currency',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pay_date' => 'date',
            'base_amount' => 'decimal:2',
            'bonus_amount' => 'decimal:2',
            'overtime_pay_amount' => 'decimal:2',
        ];
    }
}
