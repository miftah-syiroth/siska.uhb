<?php

namespace App\Filament\Resources\LetterTypes;

use App\Filament\Resources\LetterTypes\Pages\ManageLetterTypes;
use App\Models\LetterType;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class LetterTypeResource extends Resource
{
    protected static ?string $model = LetterType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if (isset($data['template_path']) && $data['template_path'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            Storage::disk('public')->delete($record->template_path);
        }
        $record->update($data);

        return $record;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('template')
                    ->collection(LetterType::MEDIA_COLLECTION)
                    ->disk('public')
                    ->label('Template File')
                    ->maxSize(1024)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('template')
                    ->url(fn (LetterType $record): ?string => $record->getFirstMediaUrl()),
                // IconColumn::make('template_path')
                //     ->label('Template')
                //     ->icon(Heroicon::DocumentText)
                //     ->url(fn (LetterType $record): ?string => $record->template_path ? asset('storage/'.$record->template_path) : null),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', direction: 'asc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                // DeleteAction::make()
                //     ->before(function (Model $record) {
                //         Storage::disk('public')->delete($record->template_path);
                //     }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->delete();
                            });
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageLetterTypes::route('/'),
        ];
    }
}
