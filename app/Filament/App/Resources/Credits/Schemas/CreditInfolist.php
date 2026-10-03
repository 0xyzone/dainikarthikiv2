<?php

namespace App\Filament\App\Resources\Credits\Schemas;

use App\Models\Credit;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CreditInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Credit Overview')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('type')
                                    ->label('Type')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state) => $state === 'given' ? 'Credit Given (Lent)' : 'Credit Taken (Borrowed)')
                                    ->color(fn (string $state) => $state === 'given' ? 'success' : 'danger')
                                    ->icon(fn (string $state) => $state === 'given' ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown),

                                TextEntry::make('person_name')
                                    ->label('Party / Person Name')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('phone')
                                    ->label('Contact')
                                    ->placeholder('N/A')
                                    ->icon('heroicon-o-phone'),

                                TextEntry::make('amount')
                                    ->label('Original Credit Amount')
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. '),

                                TextEntry::make('total_paid')
                                    ->label('Total Paid / Returned')
                                    ->state(fn (Credit $record) => $record->total_paid)
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->color('success')
                                    ->weight('bold'),

                                TextEntry::make('remaining_amount')
                                    ->label('Remaining Balance Due')
                                    ->state(fn (Credit $record) => $record->remaining_amount)
                                    ->numeric(decimalPlaces: 2)
                                    ->prefix('Rs. ')
                                    ->color(fn ($state) => $state > 0 ? 'warning' : 'gray')
                                    ->weight('bold'),

                                TextEntry::make('status')
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
                                    }),

                                TextEntry::make('date')
                                    ->label('Date')
                                    ->date(),

                                TextEntry::make('due_date')
                                    ->label('Due Date')
                                    ->date()
                                    ->placeholder('No due date specified')
                                    ->color(fn (Credit $record) => $record->isOverdue() ? 'danger' : null),
                            ]),
                    ]),

                Section::make('Notes & Attachments')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('notes')
                            ->label('Notes / Terms')
                            ->placeholder('No notes provided')
                            ->columnSpanFull(),

                        ImageEntry::make('image_path')
                            ->label('Attached Proof / Documents')
                            ->disk('public')
                            ->columnSpanFull()
                            ->placeholder('No documents attached'),
                    ]),
            ]);
    }
}
