<?php

namespace App\Filament\App\Resources\People\RelationManagers;

use App\Filament\App\Resources\Credits\Schemas\CreditForm;
use App\Models\Credit;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CreditsRelationManager extends RelationManager
{
    protected static string $relationship = 'credits';

    protected static ?string $title = 'Credits & Debts History';

    public function form(Schema $schema): Schema
    {
        return CreditForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withSum('payments', 'amount')->latest('date'))
            ->recordTitleAttribute('amount')
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'given' ? 'Credit Given' : 'Credit Taken')
                    ->color(fn (string $state) => $state === 'given' ? 'success' : 'danger')
                    ->icon(fn (string $state) => $state === 'given' ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown),

                TextColumn::make('amount')
                    ->label('Total Amount')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->sortable(),

                TextColumn::make('total_paid')
                    ->label('Paid')
                    ->state(fn (Credit $record) => (float) ($record->payments_sum_amount ?? 0))
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->color('success'),

                TextColumn::make('remaining_amount')
                    ->label('Remaining Due')
                    ->state(fn (Credit $record) => max(0, (float) $record->amount - (float) ($record->payments_sum_amount ?? 0)))
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs. ')
                    ->weight('bold')
                    ->color(fn ($state) => $state > 0 ? 'warning' : 'gray'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'settled' => 'Settled',
                        'partial' => 'Partially Paid',
                        default => 'Pending',
                    })
                    ->color(fn (string $state) => match ($state) {
                        'settled' => 'success',
                        'partial' => 'info',
                        default => 'warning',
                    }),

                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->placeholder('-'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('New Credit')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = Auth::id();
                        $data['person_name'] = $this->getOwnerRecord()->name;
                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
