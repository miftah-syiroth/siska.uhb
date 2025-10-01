<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('letter_type_id')
                    ->label('Jenis Surat')
                    ->relationship('letterType', 'name')
                    ->required(),
                TextInput::make('subject')
                    ->label('Judul')
                    ->required(),
                TextInput::make('recipient')
                    ->label('Penerima/Instansi')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('recipient_address')
                    ->label('Alamat Penerima')
                ->required()
                    ->columnSpanFull(),
                Textarea::make('note')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }
}
