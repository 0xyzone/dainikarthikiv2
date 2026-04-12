<?php

namespace App\Filament\App\Resources\IncomeRecords;

use App\Filament\App\Resources\IncomeRecords\Pages\CreateIncomeRecord;
use App\Filament\App\Resources\IncomeRecords\Pages\EditIncomeRecord;
use App\Filament\App\Resources\IncomeRecords\Pages\ListIncomeRecords;
use App\Filament\App\Resources\IncomeRecords\Schemas\IncomeRecordForm;
use App\Filament\App\Resources\IncomeRecords\Tables\IncomeRecordsTable;
use App\Models\IncomeRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class IncomeRecordResource extends Resource
{
    protected static ?string $model = IncomeRecord::class;
    protected static ?string $navigationLabel = 'Records';
    protected static ?int $navigationSort = 2;
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = 'Incomes';

    public static function form(Schema $schema): Schema
    {
        return IncomeRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IncomeRecordsTable::configure($table);
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
            'index' => ListIncomeRecords::route('/'),
            'create' => CreateIncomeRecord::route('/create'),
            'edit' => EditIncomeRecord::route('/{record}/edit'),
        ];
    }
}
