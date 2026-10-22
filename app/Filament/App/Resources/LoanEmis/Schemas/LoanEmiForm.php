<?php

namespace App\Filament\App\Resources\LoanEmis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class LoanEmiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(Auth::id()),

                Section::make('EMI Schedule Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('loan_id')
                                    ->label('Associated Loan')
                                    ->relationship(
                                        name: 'loan',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: fn ($query) => $query->where('user_id', Auth::id())->latest()
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                TextInput::make('installment_number')
                                    ->label('Installment #')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required(),

                                DatePicker::make('due_date')
                                    ->label('Due Date')
                                    ->required()
                                    ->native(false),

                                TextInput::make('amount')
                                    ->label('Scheduled EMI Amount')
                                    ->numeric()
                                    ->prefix('Rs.')
                                    ->required(),

                                TextInput::make('principal_component')
                                    ->label('Principal Component')
                                    ->numeric()
                                    ->prefix('Rs.')
                                    ->nullable(),

                                TextInput::make('interest_component')
                                    ->label('Interest Component')
                                    ->numeric()
                                    ->prefix('Rs.')
                                    ->nullable(),
                            ]),
                    ]),

                Section::make('Payment Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'paid' => 'Paid',
                                        'overdue' => 'Overdue',
                                    ])
                                    ->default('pending')
                                    ->required(),

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

                                TextInput::make('transaction_reference')
                                    ->label('Transaction Reference / Notes')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                FileUpload::make('receipt')
                                    ->label('Payment Receipt / Voucher')
                                    ->image()
                                    ->directory('loan-receipts')
                                    ->disk('public')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
