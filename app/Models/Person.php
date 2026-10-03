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
}
