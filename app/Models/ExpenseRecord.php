<?php

namespace App\Models;

use App\Models\ExpenseSource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseRecord extends Model
{
    /**
     * Get the user that owns the ExpenseRecord
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the expenseSource that owns the ExpenseRecord
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expenseSource(): BelongsTo
    {
        return $this->belongsTo(ExpenseSource::class);
    }
    protected $casts = [
        'date' => 'date',
        'image_path' => 'array',
    ];
}
