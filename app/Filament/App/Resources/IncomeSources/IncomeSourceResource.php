<?php

namespace App\Filament\App\Resources\IncomeSources;

use App\Filament\App\Resources\IncomeSources\Pages\CreateIncomeSource;
use App\Filament\App\Resources\IncomeSources\Pages\EditIncomeSource;
use App\Filament\App\Resources\IncomeSources\Pages\ListIncomeSources;
use App\Filament\App\Resources\IncomeSources\Schemas\IncomeSourceForm;
use App\Filament\App\Resources\IncomeSources\Tables\IncomeSourcesTable;
use App\Models\IncomeSource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class IncomeSourceResource extends Resource
{
    protected static ?string $model = IncomeSource::class;
    protected static ?string $navigationLabel = 'Sources';

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string | UnitEnum | null $navigationGroup = 'Incomes';

    public static function form(Schema $schema): Schema
    {
        return IncomeSourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IncomeSourcesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncomeSources::route('/'),
            'create' => CreateIncomeSource::route('/create'),
            'edit' => EditIncomeSource::route('/{record}/edit'),
        ];
    }
}
