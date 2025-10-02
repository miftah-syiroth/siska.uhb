<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Enums\TicketStatusEnum;
use App\Filament\Resources\Tickets\TicketResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Simpan')
                ->button()
                ->icon('heroicon-o-check-circle')
                ->color('primary')
                ->action(function () {
                    $this->create();
                })
                ->requiresConfirmation()
                ->modalHeading('Simpan Tiket')
                ->modalDescription('Pastikan semua data sudah benar sebelum menyimpan!'),

            Action::make('cancel')
                ->label('Batal')
                ->button()
                ->icon('heroicon-o-x-circle')
                ->color('gray')
                ->action(function () {
                    $this->redirect(ListTickets::getUrl());
                }),
        ];
    }

    public function canCreateAnother(): bool
    {
        return false;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status'] = TicketStatusEnum::SUBMITTED->value;
        do {
            $data['number'] = Str::random(10);
        } while (DB::table('tickets')->where('number', $data['number'])->exists());

        return $data;
    }
}
