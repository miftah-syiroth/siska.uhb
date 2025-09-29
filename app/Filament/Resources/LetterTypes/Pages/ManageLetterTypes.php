<?php

namespace App\Filament\Resources\LetterTypes\Pages;

use App\Filament\Resources\LetterTypes\LetterTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLetterTypes extends ManageRecords
{
    protected static string $resource = LetterTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
