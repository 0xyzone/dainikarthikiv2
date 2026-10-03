<?php

namespace App\Filament\App\Resources\Loans\RelationManagers;

use App\Models\LoanEmi;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmisRelationManager extends RelationManager
{
    protected static string $relationship = 'emis';

    protected static ?string $title = 'EMI Repayment Schedule';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('installment_number')
                    ->label('Installment #')
                    ->disabled(),

                DatePicker::make('due_date')
                    ->label('Due Date')
                    ->required()
                    ->native(false),

                TextInput::make('amount')
                    ->label('EMI Amount')
                    ->numeric()
                    ->required()
                    ->prefix('Rs.'),

                DatePicker::make('paid_date')
                    ->label('Paid Date')
                    ->native(false),

                TextInput::make('paid_amount')
                    ->label('Paid Amount')
                    ->numeric()
                    ->prefix('Rs.'),

                Select::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'Bank Transfer' => 'Bank Transfer / Auto-Debit',
                        'Cash' => 'Cash',
                        'Digital Wallet / UPI' => 'Digital Wallet (eSewa/Khalti)',
                        'Cheque' => 'Cheque',
                        'Other' => 'Other',
                    ]),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                    ])
                    ->required(),

                TextInput::make('transaction_reference')
                    ->label('Reference / Notes'),

                FileUpload::make('receipt')
                    ->label('Receipt')
                    ->image()
                    ->directory('loan-receipts')
                    ->disk('public'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('installment_number')
            ->defaultSort('installment_number', 'asc')
            ->columns([
                TextColumn::make('installment_number')
                    ->label('#')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable()
                    ->color(fn (LoanEmi $record) => $record->isOverdue() ? 'danger' : null)
                    ->description(fn (LoanEmi $record) => $record->isOverdue() ? 'Overdue!' : null),

                TextColumn::make('amount')
                    ->label('EMI Amount')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->weight('bold'),

                TextColumn::make('principal_component')
                    ->label('Principal')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->color('info')
                    ->toggleable(),

                TextColumn::make('interest_component')
                    ->label('Interest')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->color('warning')
                    ->toggleable(),

                TextColumn::make('paid_date')
                    ->label('Paid Date')
                    ->date()
                    ->placeholder('-'),

                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->placeholder('-'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->color(fn (string $state, LoanEmi $record) => match (true) {
                        $state === 'paid' => 'success',
                        $record->isOverdue() => 'danger',
                        default => 'warning',
                    }),
            ])
            ->headerActions([
                Action::make('regenerateSchedule')
                    ->label('Regenerate Schedule')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalHeading('Regenerate EMI Schedule?')
                    ->modalDescription('This will recalculate and recreate the full EMI schedule based on the loan principal, rate, and tenure.')
                    ->action(function () {
                        $loan = $this->getOwnerRecord();
                        $loan->generateEmiSchedule();

                        Notification::make()
                            ->title('EMI Schedule regenerated successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                Action::make('markPaid')
                    ->label('Pay')
                    ->icon(Heroicon::OutlinedCheck)
                    ->color('success')
                    ->button()
                    ->visible(fn (LoanEmi $record) => $record->status !== 'paid')
                    ->modalHeading(fn (LoanEmi $record) => "Pay EMI #{$record->installment_number}")
                    ->modalSubmitActionLabel('Confirm Payment')
                    ->schema([
                        DatePicker::make('paid_date')
                            ->label('Payment Date')
                            ->default(now())
                            ->native(false)
                            ->required(),

                        TextInput::make('paid_amount')
                            ->label('Paid Amount')
                            ->numeric()
                            ->prefix('Rs.')
                            ->default(fn (LoanEmi $record) => $record->amount)
                            ->required(),

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
                            ->label('Transaction Reference / Cheque No.'),

                        FileUpload::make('receipt')
                            ->label('Receipt Voucher')
                            ->image()
                            ->directory('loan-receipts')
                            ->disk('public'),
                    ])
                    ->action(function (LoanEmi $record, array $data): void {
                        $record->update([
                            'paid_date' => $data['paid_date'],
                            'paid_amount' => $data['paid_amount'],
                            'payment_method' => $data['payment_method'],
                            'transaction_reference' => $data['transaction_reference'] ?? null,
                            'receipt' => $data['receipt'] ?? null,
                            'status' => 'paid',
                        ]);

                        Notification::make()
                            ->title("EMI #{$record->installment_number} marked as Paid")
                            ->success()
                            ->send();
                    }),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([12, 24, 60, 'all']);
    }
}
