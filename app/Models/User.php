<?php

namespace App\Models;

use App\Models\ExpenseSource;
use App\Models\IncomeRecord;
use App\Models\IncomeSource;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelPasskeys\Models\Concerns\HasPasskeys;
use Spatie\LaravelPasskeys\Models\Concerns\InteractsWithPasskeys;
use Stephenjude\FilamentTwoFactorAuthentication\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail, HasAvatar, FilamentUser, HasPasskeys
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, InteractsWithPasskeys;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all of the incomeSources for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomeSources(): HasMany
    {
        return $this->hasMany(IncomeSource::class);
    }

    /**
     * Get all of the incomeRecords for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomeRecords(): HasMany
    {
        return $this->hasMany(IncomeRecord::class);
    }

    /**
     * Get all of the expenseSources for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenseSources(): HasMany
    {
        return $this->hasMany(ExpenseSource::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $avatarColumn = config('filament-edit-profile.avatar_column', 'avatar_url');
        return $this->$avatarColumn ? Storage::url($this->$avatarColumn) : null;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        // return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }
}
