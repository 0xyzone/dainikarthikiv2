<?php

namespace App\Filament\App\Widgets;

use App\Filament\App\Resources\People\PersonResource;
use App\Models\Credit;
use App\Models\Person;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonBalancesWidget extends TableWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'xl' => 1,
    ];

    protected static ?string $heading = 'Person Balances (To Collect / Repay)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Person::query()
                    ->where('user_id', Auth::id())
                    ->whereHas('credits', fn (Builder $query) => $query->where('status', '!=', 'settled'))
                    ->with([
                        'credits' => fn ($query) => $query
                            ->where('status', '!=', 'settled')
                            ->withSum('payments', 'amount'),
                    ])
                    ->orderBy('name')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Person')
                    ->weight('bold')
                    ->url(fn (Person $record): string => PersonResource::getUrl('view', ['record' => $record]))
                    ->description(function (Person $record): string {
                        $receivable = $record->pending_receivable;
                        $payable = $record->pending_payable;

                        if ($receivable > 0 && $payable > 0) {
                            return 'Collect: Rs. ' . number_format($receivable, 2) . ' | Repay: Rs. ' . number_format($payable, 2);
                        }

                        if ($receivable > 0) {
                            return 'To Collect';
                        }

                        if ($payable > 0) {
                            return 'To Repay';
                        }

                        return 'Settled';
                    }),

                TextColumn::make('pending_balance')
                    ->label('Remaining')
                    ->state(fn (Person $record): float => $record->pending_balance)
                    ->formatStateUsing(function (float $state): string {
                        if ($state > 0) {
                            return '+Rs. ' . number_format($state, 2);
                        }

                        if ($state < 0) {
                            return '-Rs. ' . number_format(abs($state), 2);
                        }

                        return 'Rs. 0.00';
                    })
                    ->weight('bold')
                    ->color(fn (float $state): string => match (true) {
                        $state > 0 => 'success',
                        $state < 0 => 'danger',
                        default => 'gray',
                    }),
            ])
            ->recordActions([
                Action::make('settle')
                    ->label('Settle')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->button()
                    ->size('sm')
                    ->modalHeading(fn (Person $record): string => 'Settle Balance with ' . $record->name)
                    ->modalDescription(function (Person $record): string {
                        $balance = $record->pending_balance;
                        $formatted = 'Rs. ' . number_format(abs($balance), 2);

                        if ($balance > 0) {
                            return "Record full collection of {$formatted} and mark all pending credits with {$record->name} as settled?";
                        }

                        if ($balance < 0) {
                            return "Record full repayment of {$formatted} and mark all pending debts with {$record->name} as settled?";
                        }

                        return "Mark all pending credits and debts with {$record->name} as settled?";
                    })
                    ->modalSubmitActionLabel('Settle Now')
                    ->schema([
                        DatePicker::make('payment_date')
                            ->label('Settlement Date')
                            ->default(now())
                            ->native(false)
                            ->required(),
                        Select::make('payment_method')
                            ->label('Payment Method')
                            ->options([
                                'Cash' => 'Cash',
                                'Bank Transfer' => 'Bank Transfer',
                                'Digital Wallet / UPI' => 'Digital Wallet / UPI (eSewa/Khalti)',
                                'Cheque' => 'Cheque',
                                'Other' => 'Other',
                            ])
                            ->default('Cash')
                            ->required(),
                        TextInput::make('notes')
                            ->label('Notes')
                            ->default('Full settlement')
                            ->maxLength(255),
                    ])
                    ->action(function (Person $record, array $data): void {
                        DB::transaction(function () use ($record, $data): void {
                            $pendingCredits = $record->credits()
                                ->where('status', '!=', 'settled')
                                ->withSum('payments', 'amount')
                                ->get();

                            /** @var Credit $credit */
                            foreach ($pendingCredits as $credit) {
                                $remaining = $credit->remaining_amount;

                                if ($remaining > 0) {
                                    $credit->payments()->create([
                                        'user_id' => Auth::id(),
                                        'amount' => $remaining,
                                        'payment_date' => $data['payment_date'],
                                        'payment_method' => $data['payment_method'],
                                        'notes' => $data['notes'] ?? 'Full settlement',
                                    ]);
                                } else {
                                    $credit->update(['status' => 'settled']);
                                }
                            }
                        });

                        Notification::make()
                            ->title("Settled balance with {$record->name}")
                            ->success()
                            ->send();
                    }),
            ])
            ->emptyStateHeading('No pending balances')
            ->emptyStateDescription('All person credits and debts are settled.')
            ->emptyStateIcon(Heroicon::OutlinedCheckBadge)
            ->paginated([5, 10]);
    }
}
