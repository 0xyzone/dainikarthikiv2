<?php

namespace App\Filament\App\Resources\Credits\Pages;

use App\Filament\App\Resources\Credits\CreditResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewCredit extends ViewRecord
{
    protected static string $resource = CreditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('recordPayment')
                ->label(fn () => $this->record->type === 'given' ? 'Collect Payment' : 'Make Payment')
                ->icon(Heroicon::OutlinedBanknotes)
                ->color('success')
                ->visible(fn () => ! $this->record->isSettled())
                ->modalHeading(fn () => ($this->record->type === 'given' ? 'Collect Payment from ' : 'Record Payment to ') . $this->record->person_name)
                ->modalDescription(fn () => 'Total: Rs. ' . number_format($this->record->amount, 2) . ' | Remaining Balance: Rs. ' . number_format($this->record->remaining_amount, 2))
                ->modalSubmitActionLabel('Save Payment')
                ->schema([
                    Hidden::make('user_id')
                        ->default(auth()->id()),

                    DatePicker::make('payment_date')
                        ->label('Payment Date')
                        ->default(now())
                        ->native(false)
                        ->required(),

                    TextInput::make('amount')
                        ->label('Payment Amount')
                        ->numeric()
                        ->required()
                        ->minValue(0.01)
                        ->prefix('Rs.')
                        ->default(fn () => $this->record->remaining_amount > 0 ? $this->record->remaining_amount : null)
                        ->helperText(fn () => 'Remaining balance: Rs. ' . number_format($this->record->remaining_amount, 2)),

                    Select::make('payment_method')
                        ->label('Payment Method')
                        ->options([
                            'Cash' => 'Cash',
                            'Bank Transfer' => 'Bank Transfer',
                            'Digital Wallet / UPI' => 'Digital Wallet / UPI (eSewa/Khalti)',
                            'Cheque' => 'Cheque',
                            'Other' => 'Other',
                        ])
                        ->default('Cash')
                        ->required(),

                    TextInput::make('notes')
                        ->label('Reference / Notes')
                        ->placeholder('e.g. Partial repayment, Bank voucher no.')
                        ->maxLength(255),

                    FileUpload::make('receipt')
                        ->label('Receipt / Voucher Image')
                        ->image()
                        ->directory('credit-payments')
                        ->disk('public')
                        ->nullable(),
                ])
                ->action(function (array $data): void {
                    $data['user_id'] = auth()->id();
                    $this->record->payments()->create($data);

                    Notification::make()
                        ->title('Payment recorded successfully')
                        ->success()
                        ->send();

                    $this->refreshFormData(['status']);
                }),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
