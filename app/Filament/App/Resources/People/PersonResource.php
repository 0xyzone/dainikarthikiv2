<?php

namespace App\Filament\App\Resources\People;

use App\Filament\App\Resources\People\Pages\CreatePerson;
use App\Filament\App\Resources\People\Pages\EditPerson;
use App\Filament\App\Resources\People\Pages\ListPeople;
use App\Filament\App\Resources\People\Pages\ViewPerson;
use App\Filament\App\Resources\People\RelationManagers\CreditsRelationManager;
use App\Filament\App\Resources\People\Schemas\PersonForm;
use App\Filament\App\Resources\People\Schemas\PersonInfolist;
use App\Filament\App\Resources\People\Tables\PersonsTable;
use App\Models\Person;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    // Navigation icon disabled because the parent group [Credits & Debts] has an icon
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|UnitEnum|null $navigationGroup = 'Credits & Debts';

    protected static ?string $navigationLabel = 'Persons';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PersonForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PersonInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PersonsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CreditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPeople::route('/'),
            'create' => CreatePerson::route('/create'),
            'view' => ViewPerson::route('/{record}'),
            'edit' => EditPerson::route('/{record}/edit'),
        ];
    }
}
