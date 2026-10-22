<?php

namespace App\Filament\App\Widgets;

use App\Filament\App\Resources\Credits\CreditResource;
use App\Models\Credit;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ActiveCreditsWidget extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Active Credits & Debts (Pending Repayment)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Credit::query()
                    ->where('user_id', Auth::id())
                    ->where('status', '!=', 'settled')
                    ->with('person')
                    ->withSum('payments', 'amount')
                    ->orderByRaw('CASE WHEN due_date IS NOT NULL AND due_date < CURDATE() THEN 0 ELSE 1 END')
                    ->latest('date')
            )
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'given' ? 'Credit Given (To Collect)' : 'Credit Taken (To Repay)')
                    ->color(fn (string $state) => $state === 'given' ? 'success' : 'danger')
                    ->icon(fn (string $state) => $state === 'given' ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown),

                TextColumn::make('person_name')
                    ->label('Party / Person')
                    ->state(fn (Credit $record) => $record->person?->name ?? $record->person_name)
                    ->description(fn (Credit $record) => ($record->person?->phone ?? $record->phone) ? '📞 ' . ($record->person?->phone ?? $record->phone) : null),

                TextColumn::make('amount')
                    ->label('Total')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. '),

                TextColumn::make('total_paid')
                    ->label('Paid')
                    ->state(fn (Credit $record) => (float) ($record->payments_sum_amount ?? 0))
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->color('success'),

                TextColumn::make('remaining_amount')
                    ->label('Remaining Due')
                    ->state(fn (Credit $record) => max(0, (float) $record->amount - (float) ($record->payments_sum_amount ?? 0)))
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->weight('bold')
                    ->color(fn ($state) => $state > 0 ? 'warning' : 'gray'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'partial' => 'Partially Paid',
                        default => 'Pending',
                    })
                    ->color(fn (string $state) => match ($state) {
                        'partial' => 'info',
                        default => 'warning',
                    }),

                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->placeholder('-')
                    ->color(fn (Credit $record) => $record->isOverdue() ? 'danger' : null)
                    ->description(fn (Credit $record) => $record->isOverdue() ? 'Overdue!' : null),
            ])
            ->recordActions([
                Action::make('recordPayment')
                    ->label(fn (Credit $record) => $record->type === 'given' ? 'Collect' : 'Pay')
                    ->icon(Heroicon::OutlinedBanknotes)
                    ->color('success')
                    ->button()
                    ->modalHeading(fn (Credit $record) => ($record->type === 'given' ? 'Collect Payment from ' : 'Record Payment to ') . ($record->person?->name ?? $record->person_name))
                    ->modalSubmitActionLabel('Save Payment')
                    ->schema([
                        Hidden::make('user_id')->default(Auth::id()),
                        DatePicker::make('payment_date')->label('Payment Date')->default(now())->native(false)->required(),
                        TextInput::make('amount')->label('Payment Amount')->numeric()->required()->minValue(0.01)->prefix('Rs.')->default(fn (Credit $record) => $record->remaining_amount > 0 ? $record->remaining_amount : null),
                        Select::make('payment_method')->label('Payment Method')->options(['Cash' => 'Cash', 'Bank Transfer' => 'Bank Transfer', 'Digital Wallet / UPI' => 'Digital Wallet / UPI (eSewa/Khalti)', 'Cheque' => 'Cheque', 'Other' => 'Other'])->default('Cash')->required(),
                        TextInput::make('notes')->label('Reference / Notes')->placeholder('e.g. Installment')->maxLength(255),
                    ])
                    ->action(function (Credit $record, array $data): void {
                        $data['user_id'] = Auth::id();
                        $record->payments()->create($data);
                        Notification::make()->title('Payment recorded successfully')->success()->send();
                    }),

                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Credit $record): string => CreditResource::getUrl('view', ['record' => $record])),
            ])
            ->emptyStateHeading('No pending credits or debts')
            ->emptyStateDescription('All loans you have given or taken are fully settled.')
            ->emptyStateIcon(Heroicon::OutlinedScale)
            ->paginated([5, 10]);
    }
}
