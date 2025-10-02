<?php

namespace App\Filament\Resources\Tickets\Tables;

use App\Enums\TicketStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->modifyQueryUsing(function (Builder $query) {
                // jika admin maka tampilkan semua, jika bukan maka sesuai author
                if (auth()->user()->hasRole('admin')) {
                    return $query;
                }

                return $query->where('user_id', auth()->id());
            })
            ->columns([
                TextColumn::make('number')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Author')
                    ->searchable(),
                TextColumn::make('letterType.name')
                    ->label('Jenis Surat'),
                TextColumn::make('subject')
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
                    DeleteBulkAction::make()
                        ->authorizeIndividualRecords('delete'),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
