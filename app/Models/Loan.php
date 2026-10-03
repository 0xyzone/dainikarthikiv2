<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'principal_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'monthly_emi' => 'decimal:2',
        'documents' => 'array',
    ];

    protected static function booted(): void
    {
        static::created(function (Loan $loan) {
            $loan->generateEmiSchedule();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function emis(): HasMany
    {
        return $this->hasMany(LoanEmi::class)->orderBy('installment_number', 'asc');
    }

    public static function calculateEmi(float $principal, float $annualRate, int $tenureMonths): float
    {
        if ($tenureMonths <= 0 || $principal <= 0) {
            return 0.0;
        }

        if ($annualRate <= 0) {
            return round($principal / $tenureMonths, 2);
        }

        $monthlyRate = ($annualRate / 12) / 100;
        $comp = pow(1 + $monthlyRate, $tenureMonths);
        $emi = ($principal * $monthlyRate * $comp) / ($comp - 1);

        return round($emi, 2);
    }

    public function generateEmiSchedule(): void
    {
        $this->emis()->delete();

        $balance = (float) $this->principal_amount;
        $monthlyRate = ((float) $this->interest_rate / 12) / 100;
        $emi = (float) $this->monthly_emi;
        $startDate = Carbon::parse($this->start_date);
        $emiDay = $this->emi_day ?: $startDate->day;

        for ($i = 1; $i <= $this->tenure_months; $i++) {
            $targetMonth = $startDate->copy()->addMonths($i);
            $dayInMonth = min($emiDay, $targetMonth->daysInMonth);
            $dueDate = $targetMonth->day($dayInMonth);

            $interestComp = $this->interest_rate > 0 ? round($balance * $monthlyRate, 2) : 0.0;
            $principalComp = $i === (int) $this->tenure_months ? $balance : round($emi - $interestComp, 2);
            $balance = max(0, $balance - $principalComp);

            $this->emis()->create([
                'user_id' => $this->user_id,
                'installment_number' => $i,
                'due_date' => $dueDate,
                'amount' => $emi,
                'principal_component' => $principalComp,
                'interest_component' => $interestComp,
                'status' => 'pending',
            ]);
        }
    }

    public function getTotalPayableAttribute(): float
    {
        return round((float) $this->monthly_emi * (int) $this->tenure_months, 2);
    }

    public function getTotalInterestAttribute(): float
    {
        return max(0, round($this->total_payable - (float) $this->principal_amount, 2));
    }

    public function getPaidEmisCountAttribute(): int
    {
        return $this->emis()->where('status', 'paid')->count();
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->emis()->where('status', 'paid')->sum('paid_amount');
    }

    public function getRemainingBalanceAttribute(): float
    {
        $totalPayable = $this->total_payable;
        $paid = $this->total_paid;

        return max(0, round($totalPayable - $paid, 2));
    }

    public function refreshLoanStatus(): void
    {
        $totalEmis = (int) $this->tenure_months;
        $paidCount = $this->emis()->where('status', 'paid')->count();

        if ($paidCount >= $totalEmis && $totalEmis > 0) {
            $this->status = 'completed';
        } else {
            $this->status = 'active';
        }

        $this->saveQuietly();
    }
}
