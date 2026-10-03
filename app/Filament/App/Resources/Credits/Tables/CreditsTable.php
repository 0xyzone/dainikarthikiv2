<?php

namespace App\Filament\App\Resources\Credits\Tables;

use App\Models\Credit;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CreditsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(static fn (Builder $query) => $query
                ->where('user_id', auth()->id())
                ->with('person')
                ->withSum('payments', 'amount')
                ->latest('date')
            )
            ->columns([
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'given' ? 'Credit Given' : 'Credit Taken')
                    ->color(fn (string $state) => $state === 'given' ? 'success' : 'danger')
                    ->icon(fn (string $state) => $state === 'given' ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown)
                    ->sortable(),

                TextColumn::make('person_name')
                    ->label('Party / Person')
                    ->state(fn (Credit $record) => $record->person?->name ?? $record->person_name)
                    ->searchable()
                    ->sortable()
                    ->description(fn (Credit $record) => ($record->person?->phone ?? $record->phone) ? "📞 " . ($record->person?->phone ?? $record->phone) : null),

                TextColumn::make('amount')
                    ->label('Total Credit')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->sortable(),

                TextColumn::make('total_paid')
                    ->label('Paid / Returned')
                    ->state(fn (Credit $record) => (float) ($record->payments_sum_amount ?? 0))
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->color('success')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('payments_sum_amount', $direction)),

                TextColumn::make('remaining_amount')
                    ->label('Balance Due')
                    ->state(fn (Credit $record) => max(0, (float) $record->amount - (float) ($record->payments_sum_amount ?? 0)))
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->weight('bold')
                    ->color(fn ($state) => $state > 0 ? 'warning' : 'gray'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'settled' => 'Settled',
                        'partial' => 'Partially Paid',
                        default => 'Pending',
                    })
                    ->color(fn (string $state) => match ($state) {
                        'settled' => 'success',
                        'partial' => 'info',
                        default => 'warning',
                    })
                    ->sortable(),

                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable()
                    ->placeholder('-')
                    ->color(fn (Credit $record) => $record->isOverdue() ? 'danger' : null)
                    ->description(fn (Credit $record) => $record->isOverdue() ? 'Overdue!' : null),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Credit Type')
                    ->options([
                        'given' => 'Credit Given (Receivable)',
                        'taken' => 'Credit Taken (Payable)',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'partial' => 'Partially Paid',
                        'settled' => 'Settled',
                    ]),

                Filter::make('overdue')
                    ->label('Overdue Only')
                    ->query(fn (Builder $query) => $query
                        ->where('status', '!=', 'settled')
                        ->whereNotNull('due_date')
                        ->where('due_date', '<', now()->toDateString())
                    ),
            ])
            ->recordActions([
                Action::make('recordPayment')
                    ->label(fn (Credit $record) => $record->type === 'given' ? 'Collect' : 'Pay')
                    ->icon(Heroicon::OutlinedBanknotes)
                    ->color('success')
                    ->visible(fn (Credit $record) => ! $record->isSettled())
                    ->modalHeading(fn (Credit $record) => ($record->type === 'given' ? 'Collect Payment from ' : 'Record Payment to ') . $record->person_name)
                    ->modalDescription(fn (Credit $record) => 'Total: Rs. ' . number_format($record->amount, 2) . ' | Remaining Balance: Rs. ' . number_format($record->remaining_amount, 2))
                    ->modalSubmitActionLabel('Save Payment')
                    ->schema([
                        Hidden::make('user_id')
                            ->default(auth()->id()),

                        DatePicker::make('payment_date')
                            ->label('Payment Date')
                            ->default(now())
                            ->native(false)
                            ->required(),

                        TextInput::make('amount')
                            ->label('Payment Amount')
                            ->numeric()
                            ->required()
                            ->minValue(0.01)
                            ->prefix('Rs.')
                            ->default(fn (Credit $record) => $record->remaining_amount > 0 ? $record->remaining_amount : null)
                            ->helperText(fn (Credit $record) => 'Remaining balance: Rs. ' . number_format($record->remaining_amount, 2)),

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
                            ->label('Reference / Notes')
                            ->placeholder('e.g. Partial repayment, Bank voucher no.')
                            ->maxLength(255),

                        FileUpload::make('receipt')
                            ->label('Receipt / Voucher Image')
                            ->image()
                            ->directory('credit-payments')
                            ->disk('public')
                            ->nullable(),
                    ])
                    ->action(function (Credit $record, array $data): void {
                        $data['user_id'] = auth()->id();
                        $record->payments()->create($data);

                        Notification::make()
                            ->title('Payment recorded successfully')
                            ->success()
                            ->send();
                    }),

                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
