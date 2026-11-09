<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveSetting extends Model
{
    /** @use HasFactory<\Database\Factories\LeaveSettingFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'paid_leave_balance',
        'last_accrued_year',
        'last_accrued_month',
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
            'paid_leave_balance' => 'decimal:2',
            'last_accrued_year' => 'integer',
            'last_accrued_month' => 'integer',
        ];
    }
}
