<?php

namespace App\Filament\App\Resources\LoanEmis;

use App\Filament\App\Resources\LoanEmis\Pages\CreateLoanEmi;
use App\Filament\App\Resources\LoanEmis\Pages\EditLoanEmi;
use App\Filament\App\Resources\LoanEmis\Pages\ListLoanEmis;
use App\Filament\App\Resources\LoanEmis\Pages\ViewLoanEmi;
use App\Filament\App\Resources\LoanEmis\Schemas\LoanEmiForm;
use App\Filament\App\Resources\LoanEmis\Schemas\LoanEmiInfolist;
use App\Filament\App\Resources\LoanEmis\Tables\LoanEmisTable;
use App\Models\LoanEmi;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class LoanEmiResource extends Resource
{
    protected static ?string $model = LoanEmi::class;

    // Navigation icon disabled because parent group [Credits & Debts] has an icon
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Credits & Debts';

    protected static ?string $navigationLabel = 'EMIs';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'installment_number';

    public static function getNavigationBadge(): ?string
    {
        $dueCount = static::getModel()::where('user_id', Auth::id())
            ->where('status', '!=', 'paid')
            ->where('due_date', '<=', now()->endOfMonth())
            ->count();

        return $dueCount > 0 ? (string) $dueCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return LoanEmiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LoanEmiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoanEmisTable::configure($table);
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
            'index' => ListLoanEmis::route('/'),
            'create' => CreateLoanEmi::route('/create'),
            'view' => ViewLoanEmi::route('/{record}'),
            'edit' => EditLoanEmi::route('/{record}/edit'),
        ];
    }
}
