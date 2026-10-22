<?php

namespace App\Filament\App\Resources\LoanEmis\Tables;

use App\Models\LoanEmi;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LoanEmisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(static fn (Builder $query) => $query
                ->where('user_id', Auth::id())
                ->with(['loan'])
                ->orderBy('due_date', 'asc')
            )
            ->columns([
                TextColumn::make('loan.title')
                    ->label('Loan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (LoanEmi $record) => $record->loan?->lender),

                TextColumn::make('installment_number')
                    ->label('#')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable()
                    ->color(fn (LoanEmi $record) => $record->isOverdue() ? 'danger' : null)
                    ->description(fn (LoanEmi $record) => $record->isOverdue() ? 'Overdue!' : null),

                TextColumn::make('amount')
                    ->label('Scheduled EMI')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('paid_amount')
                    ->label('Paid Amount')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->color('success')
                    ->placeholder('-'),

                TextColumn::make('paid_date')
                    ->label('Paid Date')
                    ->date()
                    ->placeholder('-')
                    ->sortable(),

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
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('loan_id')
                    ->label('Loan')
                    ->relationship(
                        name: 'loan',
                        titleAttribute: 'title',
                        modifyQueryUsing: fn ($query) => $query->where('user_id', Auth::id())
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                    ]),

                Filter::make('due_this_month')
                    ->label('Due This Month')
                    ->query(fn (Builder $query) => $query
                        ->whereYear('due_date', now()->year)
                        ->whereMonth('due_date', now()->month)
                    ),

                Filter::make('overdue_only')
                    ->label('Overdue Only')
                    ->query(fn (Builder $query) => $query
                        ->where('status', '!=', 'paid')
                        ->where('due_date', '<', now()->toDateString())
                    ),
            ])
            ->recordActions([
                Action::make('markPaid')
                    ->label('Pay EMI')
                    ->icon(Heroicon::OutlinedBanknotes)
                    ->color('success')
                    ->button()
                    ->visible(fn (LoanEmi $record) => $record->status !== 'paid')
                    ->modalHeading(fn (LoanEmi $record) => "Pay EMI #{$record->installment_number} for {$record->loan?->title}")
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
                            ->label('Transaction Reference / Cheque No.')
                            ->placeholder('e.g. TXN123456'),

                        FileUpload::make('receipt')
                            ->label('Payment Receipt / Voucher')
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

                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('due_date', 'asc');
    }
}
