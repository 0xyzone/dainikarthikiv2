<?php

namespace App\Filament\App\Resources\Loans;

use App\Filament\App\Resources\Loans\Pages\CreateLoan;
use App\Filament\App\Resources\Loans\Pages\EditLoan;
use App\Filament\App\Resources\Loans\Pages\ListLoans;
use App\Filament\App\Resources\Loans\Pages\ViewLoan;
use App\Filament\App\Resources\Loans\RelationManagers\EmisRelationManager;
use App\Filament\App\Resources\Loans\Schemas\LoanForm;
use App\Filament\App\Resources\Loans\Schemas\LoanInfolist;
use App\Filament\App\Resources\Loans\Tables\LoansTable;
use App\Models\Loan;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    // Navigation icon disabled because parent group [Credits & Debts] has an icon
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Credits & Debts';

    protected static ?string $navigationLabel = 'Loans';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('user_id', auth()->id())
            ->where('status', 'active')
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function form(Schema $schema): Schema
    {
        return LoanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LoanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            EmisRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLoans::route('/'),
            'create' => CreateLoan::route('/create'),
            'view' => ViewLoan::route('/{record}'),
            'edit' => EditLoan::route('/{record}/edit'),
        ];
    }
}
