<?php

namespace App\Models;

use App\Models\ExpenseSource;
use App\Models\IncomeRecord;
use App\Models\IncomeSource;
use Database\Factories\UserFactory;
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

    public function expenseRecords(): HasMany
    {
        return $this->hasMany(ExpenseRecord::class);
    }

    public function credits(): HasMany
    {
        return $this->hasMany(Credit::class);
    }

    public function creditPayments(): HasMany
    {
        return $this->hasMany(CreditPayment::class);
    }

    public function persons(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function loanEmis(): HasMany
    {
        return $this->hasMany(LoanEmi::class);
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

    public function sendEmailVerificationNotification(): void
    {
        if (! $this->getKey()) {
            return;
        }

        $currentPanel = \Filament\Facades\Filament::getCurrentPanel();
        $panel = $currentPanel && $currentPanel->hasEmailVerification()
            ? $currentPanel
            : \Filament\Facades\Filament::getPanel('app');

        $notification = app(\Filament\Auth\Notifications\VerifyEmail::class);
        $notification->url = $panel->getVerifyEmailUrl($this);

        if (method_exists($this, 'notifyNow')) {
            $this->notifyNow($notification);
        } else {
            $this->notify($notification);
        }
    }
}
