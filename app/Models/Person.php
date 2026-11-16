<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function credits(): HasMany
    {
        return $this->hasMany(Credit::class)->latest('date');
    }

    public function getTotalGivenAttribute(): float
    {
        return (float) $this->credits()->where('type', 'given')->sum('amount');
    }

    public function getTotalTakenAttribute(): float
    {
        return (float) $this->credits()->where('type', 'taken')->sum('amount');
    }

    /**
     * Sum remaining balance for pending/partial credits of a given type.
     */
    protected function sumPendingRemaining(string $type): float
    {
        $credits = $this->relationLoaded('credits')
            ? $this->credits
            : $this->credits()->where('status', '!=', 'settled')->withSum('payments', 'amount')->get();

        $total = $credits
            ->where('type', $type)
            ->where('status', '!=', 'settled')
            ->sum(fn (Credit $credit): float => $credit->remaining_amount);

        return round((float) $total, 2);
    }

    public function getPendingReceivableAttribute(): float
    {
        return $this->sumPendingRemaining('given');
    }

    public function getPendingPayableAttribute(): float
    {
        return $this->sumPendingRemaining('taken');
    }

    public function getPendingBalanceAttribute(): float
    {
        return round($this->pending_receivable - $this->pending_payable, 2);
    }
}
