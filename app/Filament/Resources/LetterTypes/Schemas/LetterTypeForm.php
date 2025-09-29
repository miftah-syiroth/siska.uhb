<?php

namespace App\Filament\Resources\LetterTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LetterTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('template_path'),
            ]);
    }
}
