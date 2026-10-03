<?php

namespace App\Filament\App\Resources\Loans\Tables;

use App\Models\Loan;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LoansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(static fn (Builder $query) => $query
                ->where('user_id', auth()->id())
                ->with(['emis'])
                ->latest()
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Loan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Loan $record) => $record->lender),

                TextColumn::make('loan_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ucfirst($state)),

                TextColumn::make('principal_amount')
                    ->label('Principal')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->sortable(),

                TextColumn::make('interest_rate')
                    ->label('Rate')
                    ->suffix('%')
                    ->sortable(),

                TextColumn::make('monthly_emi')
                    ->label('Monthly EMI')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->weight('bold')
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('emis_progress')
                    ->label('Progress')
                    ->state(fn (Loan $record) => "{$record->paid_emis_count} / {$record->tenure_months} EMIs")
                    ->badge()
                    ->color(fn (Loan $record) => $record->paid_emis_count === (int) $record->tenure_months ? 'success' : 'info'),

                TextColumn::make('remaining_balance')
                    ->label('Remaining')
                    ->state(fn (Loan $record) => $record->remaining_balance)
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->weight('bold')
                    ->color(fn ($state) => $state > 0 ? 'warning' : 'gray'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->color(fn (string $state) => match ($state) {
                        'completed' => 'success',
                        'defaulted' => 'danger',
                        default => 'primary',
                    }),

                TextColumn::make('start_date')
                    ->label('Started')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'defaulted' => 'Defaulted',
                    ]),

                SelectFilter::make('loan_type')
                    ->options([
                        'personal' => 'Personal Loan',
                        'home' => 'Home Loan',
                        'vehicle' => 'Vehicle Loan',
                        'education' => 'Education Loan',
                        'business' => 'Business Loan',
                        'other' => 'Other',
                    ]),
            ])
            ->recordActions([
                Action::make('payNextEmi')
                    ->label('Pay EMI')
                    ->icon(Heroicon::OutlinedBanknotes)
                    ->color('success')
                    ->visible(fn (Loan $record) => $record->status === 'active' && $record->emis()->where('status', '!=', 'paid')->exists())
                    ->modalHeading(fn (Loan $record) => "Pay EMI for {$record->title}")
                    ->modalDescription(function (Loan $record) {
                        $nextEmi = $record->emis()->where('status', '!=', 'paid')->first();
                        return $nextEmi ? "Installment #{$nextEmi->installment_number} of {$record->tenure_months} | Due: " . $nextEmi->due_date->format('M d, Y') : '';
                    })
                    ->modalSubmitActionLabel('Confirm Payment')
                    ->schema([
                        DatePicker::make('paid_date')
                            ->label('Payment Date')
                            ->default(now())
                            ->native(false)
                            ->required(),

                        TextInput::make('paid_amount')
                            ->label('Amount Paid')
                            ->numeric()
                            ->required()
                            ->prefix('Rs.')
                            ->default(function (Loan $record) {
                                $nextEmi = $record->emis()->where('status', '!=', 'paid')->first();
                                return $nextEmi ? $nextEmi->amount : $record->monthly_emi;
                            }),

                        Select::make('payment_method')
                            ->label('Payment Method')
                            ->options([
                                'Bank Transfer' => 'Bank Transfer / Auto-Debit',
                                'Cash' => 'Cash',
                                'Digital Wallet / UPI' => 'Digital Wallet (eSewa/Khalti)',
                                'Cheque' => 'Cheque',
                                'Other' => 'Other',
                            ])
                            ->default('Bank Transfer')
                            ->required(),

                        TextInput::make('transaction_reference')
                            ->label('Transaction Reference / Cheque No.')
                            ->placeholder('e.g. TXN987654321'),

                        FileUpload::make('receipt')
                            ->label('Payment Receipt / Voucher')
                            ->image()
                            ->directory('loan-receipts')
                            ->disk('public')
                            ->nullable(),
                    ])
                    ->action(function (Loan $record, array $data): void {
                        $nextEmi = $record->emis()->where('status', '!=', 'paid')->first();
                        if ($nextEmi) {
                            $nextEmi->update([
                                'paid_date' => $data['paid_date'],
                                'paid_amount' => $data['paid_amount'],
                                'payment_method' => $data['payment_method'],
                                'transaction_reference' => $data['transaction_reference'] ?? null,
                                'receipt' => $data['receipt'] ?? null,
                                'status' => 'paid',
                            ]);

                            Notification::make()
                                ->title("EMI #{$nextEmi->installment_number} marked as Paid")
                                ->success()
                                ->send();
                        }
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
