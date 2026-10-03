<?php

namespace App\Filament\App\Resources\People\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PersonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Person Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Name / Entity')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('N/A')
                                    ->icon('heroicon-o-phone'),

                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->placeholder('N/A')
                                    ->icon('heroicon-o-envelope'),

                                TextEntry::make('address')
                                    ->label('Address')
                                    ->placeholder('N/A')
                                    ->icon('heroicon-o-map-pin'),

                                TextEntry::make('notes')
                                    ->label('Notes')
                                    ->placeholder('No notes recorded')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
