<?php

namespace App\Filament\App\Resources\IncomeRecords\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IncomeRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(auth()->id()),
                Select::make('income_source_id')
                    ->relationship(
                        name: 'incomeSource', 
                        titleAttribute: 'name',
                        modifyQueryUsing: static fn($query) => $query->where('user_id', auth()->id())->latest())
                    ->disablePlaceholderSelection()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                        TextInput::make('name')
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        FileUpload::make('image_path')
                            ->image()
                            ->nullable(),
                    ])
                    ->required(),
                DatePicker::make('date')
                    ->required()
                    ->native(false)
                    ->placeholder('Select date'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                FileUpload::make('image_path')
                    ->label('Receipt Images')
                    ->image()
                    ->multiple()
                    ->directory('income-records')
                    ->disk('public')
                    ->panelLayout('grid')
                    ->maxFiles(5)
                    ->nullable(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
