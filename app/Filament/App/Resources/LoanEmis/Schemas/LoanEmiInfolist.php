<?php

namespace App\Filament\App\Resources\LoanEmis\Schemas;

use App\Models\LoanEmi;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LoanEmiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('EMI Installment Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('loan.title')
                                    ->label('Loan Name')
                                    ->weight('bold'),

                                TextEntry::make('loan.lender')
                                    ->label('Lender / Bank')
                                    ->icon('heroicon-o-building-library'),

                                TextEntry::make('installment_number')
                                    ->label('Installment #')
                                    ->badge()
                                    ->color('gray'),

                                TextEntry::make('due_date')
                                    ->label('Due Date')
                                    ->date()
                                    ->color(fn (LoanEmi $record) => $record->isOverdue() ? 'danger' : null),

                                TextEntry::make('amount')
                                    ->label('Scheduled EMI')
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->weight('bold'),

                                TextEntry::make('status')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                                    ->color(fn (string $state, LoanEmi $record) => match (true) {
                                        $state === 'paid' => 'success',
                                        $record->isOverdue() => 'danger',
                                        default => 'warning',
                                    }),

                                TextEntry::make('principal_component')
                                    ->label('Principal Component')
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->placeholder('-'),

                                TextEntry::make('interest_component')
                                    ->label('Interest Component')
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->placeholder('-'),

                                TextEntry::make('paid_amount')
                                    ->label('Paid Amount')
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->color('success')
                                    ->placeholder('Not yet paid'),

                                TextEntry::make('paid_date')
                                    ->label('Paid Date')
                                    ->date()
                                    ->placeholder('-'),

                                TextEntry::make('payment_method')
                                    ->label('Payment Method')
                                    ->badge()
                                    ->placeholder('-'),

                                TextEntry::make('transaction_reference')
                                    ->label('Transaction Reference')
                                    ->placeholder('-'),
                            ]),
                    ]),

                Section::make('Receipt & Notes')
                    ->collapsible()
                    ->schema([
                        ImageEntry::make('receipt')
                            ->label('Attached Receipt / Voucher')
                            ->disk('public')
                            ->columnSpanFull()
                            ->placeholder('No receipt uploaded'),

                        TextEntry::make('notes')
                            ->label('Notes')
                            ->placeholder('No notes recorded')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
