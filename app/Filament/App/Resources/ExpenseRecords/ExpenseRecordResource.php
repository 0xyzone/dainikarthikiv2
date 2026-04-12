<?php

namespace App\Filament\App\Resources\ExpenseRecords;

use App\Filament\App\Resources\ExpenseRecords\Pages\CreateExpenseRecord;
use App\Filament\App\Resources\ExpenseRecords\Pages\EditExpenseRecord;
use App\Filament\App\Resources\ExpenseRecords\Pages\ListExpenseRecords;
use App\Filament\App\Resources\ExpenseRecords\Schemas\ExpenseRecordForm;
use App\Filament\App\Resources\ExpenseRecords\Tables\ExpenseRecordsTable;
use App\Models\ExpenseRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ExpenseRecordResource extends Resource
{
    protected static ?string $model = ExpenseRecord::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Records';
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = 'Expenses';

    public static function form(Schema $schema): Schema
    {
        return ExpenseRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpenseRecordsTable::configure($table);
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
            'index' => ListExpenseRecords::route('/'),
            'create' => CreateExpenseRecord::route('/create'),
            'edit' => EditExpenseRecord::route('/{record}/edit'),
        ];
    }
}
