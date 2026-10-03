<?php

namespace App\Filament\App\Resources\Loans\Schemas;

use App\Models\Loan;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LoanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Loan Summary')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Loan Name')
                                    ->weight('bold'),

                                TextEntry::make('lender')
                                    ->label('Lender / Bank')
                                    ->icon('heroicon-o-building-library'),

                                TextEntry::make('loan_type')
                                    ->label('Type')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state) => ucfirst($state) . ' Loan'),

                                TextEntry::make('principal_amount')
                                    ->label('Principal Borrowed')
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. '),

                                TextEntry::make('interest_rate')
                                    ->label('Interest Rate')
                                    ->suffix('% p.a.'),

                                TextEntry::make('tenure_months')
                                    ->label('Tenure')
                                    ->suffix(' Months'),

                                TextEntry::make('monthly_emi')
                                    ->label('Monthly EMI')
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->weight('bold')
                                    ->color('primary'),

                                TextEntry::make('total_payable')
                                    ->label('Total Payable')
                                    ->state(fn (Loan $record) => $record->total_payable)
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. '),

                                TextEntry::make('total_interest')
                                    ->label('Total Interest')
                                    ->state(fn (Loan $record) => $record->total_interest)
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->color('warning'),

                                TextEntry::make('paid_progress')
                                    ->label('EMIs Paid')
                                    ->state(fn (Loan $record) => "{$record->paid_emis_count} of {$record->tenure_months} EMIs")
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('total_paid')
                                    ->label('Total Amount Paid')
                                    ->state(fn (Loan $record) => $record->total_paid)
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->color('success'),

                                TextEntry::make('remaining_balance')
                                    ->label('Remaining Balance')
                                    ->state(fn (Loan $record) => $record->remaining_balance)
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->weight('bold')
                                    ->color(fn ($state) => $state > 0 ? 'danger' : 'gray'),
                            ]),
                    ]),

                Section::make('Notes & Terms')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('notes')
                            ->label('Terms / Collateral / Notes')
                            ->placeholder('No notes specified')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
