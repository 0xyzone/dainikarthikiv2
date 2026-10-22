<?php

namespace App\Filament\App\Resources\Loans\Schemas;

use App\Models\Loan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class LoanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(Auth::id()),

                Section::make('Loan Information')
                    ->description('Basic details and lender information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Loan Title / Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g. NIC Asia Home Loan, Car Loan'),

                                TextInput::make('lender')
                                    ->label('Lender / Bank')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g. Nabil Bank, Global IME'),

                                Select::make('loan_type')
                                    ->label('Loan Type')
                                    ->options([
                                        'personal' => 'Personal Loan',
                                        'home' => 'Home / Housing Loan',
                                        'vehicle' => 'Vehicle / Auto Loan',
                                        'education' => 'Education Loan',
                                        'business' => 'Business Loan',
                                        'other' => 'Other',
                                    ])
                                    ->default('personal')
                                    ->required(),

                                DatePicker::make('start_date')
                                    ->label('Disbursement Date')
                                    ->required()
                                    ->native(false)
                                    ->default(now()),

                                TextInput::make('emi_day')
                                    ->label('Monthly EMI Due Day')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->maxValue(31)
                                    ->helperText('Day of the month the EMI is due (1 - 31)'),

                                Select::make('status')
                                    ->label('Loan Status')
                                    ->options([
                                        'active' => 'Active',
                                        'completed' => 'Completed / Closed',
                                        'defaulted' => 'Defaulted',
                                    ])
                                    ->default('active')
                                    ->required(),
                            ]),
                    ]),

                Section::make('EMI Calculation & Financial Terms')
                    ->description('Enter the principal, annual rate, and tenure to automatically calculate the monthly EMI.')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('principal_amount')
                                    ->label('Loan Amount (Principal)')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->prefix('Rs.')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($get, $set) => self::recalculateEmi($get, $set)),

                                TextInput::make('interest_rate')
                                    ->label('Annual Interest Rate')
                                    ->required()
                                    ->numeric()
                                    ->suffix('%')
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->step('0.01')
                                    ->default(10.0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($get, $set) => self::recalculateEmi($get, $set)),

                                TextInput::make('tenure_months')
                                    ->label('Tenure')
                                    ->required()
                                    ->numeric()
                                    ->suffix('Months')
                                    ->minValue(1)
                                    ->maxValue(600)
                                    ->default(60)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($get, $set) => self::recalculateEmi($get, $set)),

                                TextInput::make('monthly_emi')
                                    ->label('Monthly EMI')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rs.')
                                    ->helperText('Auto-calculated. Adjust if your bank has a custom EMI.'),

                                Placeholder::make('total_payable_preview')
                                    ->label('Total Payable (Estimated)')
                                    ->content(fn ($get) => 'Rs. ' . number_format((float) ($get('monthly_emi') ?? 0) * (int) ($get('tenure_months') ?? 0), 2)),

                                Placeholder::make('total_interest_preview')
                                    ->label('Total Interest (Estimated)')
                                    ->content(fn ($get) => 'Rs. ' . number_format(max(0, ((float) ($get('monthly_emi') ?? 0) * (int) ($get('tenure_months') ?? 0)) - (float) ($get('principal_amount') ?? 0)), 2)),
                            ]),
                    ]),

                Section::make('Documents & Notes')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('documents')
                            ->label('Loan Documents / Sanction Letters')
                            ->multiple()
                            ->directory('loans')
                            ->disk('public')
                            ->panelLayout('grid')
                            ->maxFiles(5)
                            ->nullable(),

                        Textarea::make('notes')
                            ->label('Terms / Collateral / Notes')
                            ->rows(3)
                            ->columnSpanFull()
                            ->nullable(),
                    ]),
            ]);
    }

    public static function recalculateEmi(Get $get, Set $set): void
    {
        $principal = (float) ($get('principal_amount') ?? 0);
        $rate = (float) ($get('interest_rate') ?? 0);
        $tenure = (int) ($get('tenure_months') ?? 0);

        if ($principal > 0 && $tenure > 0) {
            $emi = Loan::calculateEmi($principal, $rate, $tenure);
            $set('monthly_emi', $emi);
        }
    }
}
