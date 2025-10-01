<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Enums\TicketStatusEnum;
use App\Filament\Resources\Tickets\TicketResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status'] = TicketStatusEnum::SUBMITTED->value;
        $data['number'] = Str::random(6);

        return $data;
    }
}
