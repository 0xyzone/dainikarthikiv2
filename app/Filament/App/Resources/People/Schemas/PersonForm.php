<?php

namespace App\Filament\App\Resources\People\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(Auth::id()),

                Section::make('Person / Counterparty Details')
                    ->description('Store details of people you lend to or borrow from.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name / Entity')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g. Ram Sharma, ABC Traders'),

                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->maxLength(50)
                                    ->placeholder('e.g. 98XXXXXXXX'),

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->maxLength(255)
                                    ->placeholder('e.g. contact@example.com'),

                                TextInput::make('address')
                                    ->label('Address / Location')
                                    ->maxLength(255)
                                    ->placeholder('e.g. Kathmandu, Nepal'),

                                Textarea::make('notes')
                                    ->label('Notes / Relationship Information')
                                    ->rows(3)
                                    ->columnSpanFull()
                                    ->placeholder('Additional details or context...'),
                            ]),
                    ]),
            ]);
    }
}
