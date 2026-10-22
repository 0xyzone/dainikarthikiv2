<?php

namespace App\Filament\App\Resources\Credits\Schemas;

use App\Models\Person;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class CreditForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(Auth::id()),

                Section::make('Credit Details')
                    ->description('Specify whether you gave or took this credit and the counterparty details.')
                    ->schema([
                        ToggleButtons::make('type')
                            ->label('Credit Type')
                            ->options([
                                'given' => 'Credit Given (I Lent / Receivable)',
                                'taken' => 'Credit Taken (I Borrowed / Payable)',
                            ])
                            ->colors([
                                'given' => 'success',
                                'taken' => 'danger',
                            ])
                            ->icons([
                                'given' => Heroicon::OutlinedArrowTrendingUp,
                                'taken' => Heroicon::OutlinedArrowTrendingDown,
                            ])
                            ->default('given')
                            ->inline()
                            ->required()
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                Select::make('person_id')
                                    ->label('Person / Counterparty')
                                    ->relationship(
                                        name: 'person',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: static fn ($query) => $query->where('user_id', Auth::id())->latest('name')
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($person = Person::find($state)) {
                                            $set('person_name', $person->name);
                                            if ($person->phone) {
                                                $set('phone', $person->phone);
                                            }
                                        }
                                    })
                                    ->createOptionForm([
                                        Hidden::make('user_id')
                                            ->default(Auth::id()),

                                        TextInput::make('name')
                                            ->label('Full Name / Entity')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g. Ram Sharma, ABC Traders'),

                                        TextInput::make('phone')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->maxLength(50)
                                            ->placeholder('e.g. 98XXXXXXXX'),

                                        TextInput::make('email')
                                            ->label('Email Address')
                                            ->email()
                                            ->maxLength(255)
                                            ->placeholder('name@example.com'),

                                        TextInput::make('address')
                                            ->label('Address / Location')
                                            ->maxLength(255)
                                            ->placeholder('e.g. Kathmandu, Nepal'),

                                        Textarea::make('notes')
                                            ->label('Notes')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->createOptionUsing(function (array $data): int {
                                        $data['user_id'] = Auth::id();
                                        $person = Person::create($data);
                                        return $person->id;
                                    }),

                                Hidden::make('person_name'),

                                TextInput::make('phone')
                                    ->label('Contact / Phone')
                                    ->tel()
                                    ->maxLength(50)
                                    ->placeholder('e.g. 98XXXXXXXX'),

                                TextInput::make('amount')
                                    ->label('Total Credit Amount')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0.01)
                                    ->prefix('Rs.'),

                                DatePicker::make('date')
                                    ->label('Transaction Date')
                                    ->required()
                                    ->native(false)
                                    ->default(now()),

                                DatePicker::make('due_date')
                                    ->label('Due Date')
                                    ->native(false)
                                    ->nullable()
                                    ->helperText('Expected settlement date (optional)'),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'partial' => 'Partially Paid',
                                        'settled' => 'Settled',
                                    ])
                                    ->default('pending')
                                    ->required()
                                    ->helperText('Status auto-adjusts based on recorded payments.'),
                            ]),
                    ]),

                Section::make('Documents & Notes')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Documents & Receipts (Agreements / Proofs / Screenshots)')
                            ->image()
                            ->multiple()
                            ->directory('credits')
                            ->disk('public')
                            ->panelLayout('grid')
                            ->maxFiles(5)
                            ->nullable(),

                        Textarea::make('notes')
                            ->label('Notes / Purpose / Terms')
                            ->rows(3)
                            ->columnSpanFull()
                            ->nullable(),
                    ]),
            ]);
    }
}
