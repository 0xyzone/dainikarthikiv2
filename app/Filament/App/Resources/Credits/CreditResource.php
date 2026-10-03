<?php

namespace App\Filament\App\Resources\Credits;

use App\Filament\App\Resources\Credits\Pages\CreateCredit;
use App\Filament\App\Resources\Credits\Pages\EditCredit;
use App\Filament\App\Resources\Credits\Pages\ListCredits;
use App\Filament\App\Resources\Credits\Pages\ViewCredit;
use App\Filament\App\Resources\Credits\RelationManagers\PaymentsRelationManager;
use App\Filament\App\Resources\Credits\Schemas\CreditForm;
use App\Filament\App\Resources\Credits\Schemas\CreditInfolist;
use App\Filament\App\Resources\Credits\Tables\CreditsTable;
use App\Models\Credit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CreditResource extends Resource
{
    protected static ?string $model = Credit::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|UnitEnum|null $navigationGroup = 'Credits & Debts';

    protected static ?string $navigationLabel = 'Records';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'person_name';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('user_id', auth()->id())
            ->where('status', '!=', 'settled')
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return CreditForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CreditInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CreditsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCredits::route('/'),
            'create' => CreateCredit::route('/create'),
            'view' => ViewCredit::route('/{record}'),
            'edit' => EditCredit::route('/{record}/edit'),
        ];
    }
}
