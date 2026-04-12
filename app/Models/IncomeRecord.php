<?php

namespace App\Models;

use App\Models\IncomeSource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomeRecord extends Model
{
    /**
     * Get the incomeSource that owns the IncomeRecord
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incomeSource(): BelongsTo
    {
        return $this->belongsTo(IncomeSource::class);
    }

    /**
     * Get the user that owns the IncomeRecord
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'date' => 'date',
        'image_path' => 'array',
    ];
}
