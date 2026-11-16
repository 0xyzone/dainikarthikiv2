<?php

namespace App\Filament\App\Resources\People\Tables;

use App\Models\Person;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PersonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(static fn (Builder $query) => $query
                ->where('user_id', Auth::id())
                ->withCount('credits')
                ->with([
                    'credits' => fn ($creditQuery) => $creditQuery
                        ->where('status', '!=', 'settled')
                        ->withSum('payments', 'amount'),
                ])
                ->latest()
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->placeholder('-')
                    ->copyable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('address')
                    ->label('Address')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('credits_count')
                    ->label('Credit Records')
                    ->counts('credits')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('pending_balance')
                    ->label('Remaining Balance')
                    ->state(fn (Person $record): float => $record->pending_balance)
                    ->formatStateUsing(function (float $state): string {
                        if ($state > 0) {
                            return '+Rs. ' . number_format($state, 2);
                        }

                        if ($state < 0) {
                            return '-Rs. ' . number_format(abs($state), 2);
                        }

                        return 'Rs. 0.00';
                    })
                    ->description(function (Person $record): string {
                        $receivable = $record->pending_receivable;
                        $payable = $record->pending_payable;

                        if ($receivable > 0 && $payable > 0) {
                            return 'Collect: Rs. ' . number_format($receivable, 2) . ' | Repay: Rs. ' . number_format($payable, 2);
                        }

                        if ($receivable > 0) {
                            return 'To Collect';
                        }

                        if ($payable > 0) {
                            return 'To Repay';
                        }

                        return 'Settled';
                    })
                    ->weight('bold')
                    ->color(fn (float $state): string => match (true) {
                        $state > 0 => 'success',
                        $state < 0 => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Added On')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
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
