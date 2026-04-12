<?php

namespace App\Filament\App\Resources\ExpenseSources;

use App\Filament\App\Resources\ExpenseSources\Pages\CreateExpenseSource;
use App\Filament\App\Resources\ExpenseSources\Pages\EditExpenseSource;
use App\Filament\App\Resources\ExpenseSources\Pages\ListExpenseSources;
use App\Filament\App\Resources\ExpenseSources\Schemas\ExpenseSourceForm;
use App\Filament\App\Resources\ExpenseSources\Tables\ExpenseSourcesTable;
use App\Models\ExpenseSource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ExpenseSourceResource extends Resource
{
    protected static ?string $model = ExpenseSource::class;
    protected static ?string $navigationLabel = 'Sources';

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string | UnitEnum | null $navigationGroup = 'Expenses';

    public static function form(Schema $schema): Schema
    {
        return ExpenseSourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpenseSourcesTable::configure($table);
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
            'index' => ListExpenseSources::route('/'),
            'create' => CreateExpenseSource::route('/create'),
            'edit' => EditExpenseSource::route('/{record}/edit'),
        ];
    }
}
