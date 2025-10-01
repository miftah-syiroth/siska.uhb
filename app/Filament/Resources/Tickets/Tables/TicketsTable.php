<?php

namespace App\Filament\Resources\Tickets\Tables;

use App\Enums\TicketStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->columns([
                TextColumn::make('number')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Pengirim')
                    ->searchable(),
                TextColumn::make('letterType.name')
                    ->label('Jenis Surat')
                    ->searchable(),
                TextColumn::make('subject')
                    ->searchable(),
                TextColumn::make('recipient')
                    ->searchable(),
                TextColumn::make('status_label')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        TicketStatusEnum::DRAFT->value => 'gray',
                        TicketStatusEnum::SUBMITTED->value => 'blue',
                        TicketStatusEnum::IN_PROGRESS->value => 'yellow',
                        TicketStatusEnum::APPROVED->value => 'green',
                        TicketStatusEnum::REJECTED->value => 'red',
                        TicketStatusEnum::CANCELLED->value => 'gray',
                        default => 'gray',
                    })
                    ->label('Status'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', direction: 'desc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
