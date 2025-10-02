<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Models\Ticket;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        // masukkan ke dalam card
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('subject')
                            ->label('Judul')
                            ->required(),
                        Textarea::make('note')
                            ->label('Catatan')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])->columnSpan([
                        'lg' => 2,
                    ]),
                Section::make()
                    ->schema([
                        Select::make('letter_type_id')
                            ->label('Jenis Surat')
                            ->relationship('letterType', 'name')
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('attachment')
                            ->collection(Ticket::MEDIA_COLLECTION)
                            ->disk('public')
                            ->label('Lampiran')
                            ->maxSize(1024),
                    ]),

            ])->columns(3);
    }
}
