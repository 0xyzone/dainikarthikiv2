<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Credit extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'image_path' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Credit $credit) {
            if ($credit->person_id && empty($credit->person_name)) {
                $credit->person_name = $credit->person?->name;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(CreditPayment::class)->latest('payment_date');
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) ($this->payments_sum_amount ?? $this->payments()->sum('amount'));
    }

    public function getRemainingAmountAttribute(): float
    {
        $paid = $this->total_paid;
        $remaining = (float) $this->amount - $paid;

        return max(0, $remaining);
    }

    public function refreshPaymentStatus(): void
    {
        $paid = (float) $this->payments()->sum('amount');
        $total = (float) $this->amount;

        if ($paid <= 0) {
            $this->status = 'pending';
        } elseif ($paid >= $total) {
            $this->status = 'settled';
        } else {
            $this->status = 'partial';
        }

        $this->saveQuietly();
    }

    public function isSettled(): bool
    {
        return $this->status === 'settled';
    }

    public function isOverdue(): bool
    {
        return ! $this->isSettled() && $this->due_date && $this->due_date->isPast();
    }
}
