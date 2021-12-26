<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookmarkResource\Pages;
use App\Filament\Resources\BookmarkResource\RelationManagers;
use App\Models\Bookmark;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookmarkResource extends Resource
{
    protected static ?string $model = Bookmark::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('description'),
                TextInput::make('url')->required(),
                SpatieTagsInput::make('tags'),
                BelongsToSelect::make('provider_id')
                    ->relationship('provider', 'name')->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                ImageColumn::make('image')->width(200),
                TextColumn::make('name'),
                SpatieTagsColumn::make('tags'),
                TextColumn::make('type'),
                TextColumn::make('provider')->getStateUsing(function ($record) {
                    return $record->provider->name ?? '';
                }),
                TextColumn::make('updated_at')->date('Y-m-d H:i')->sortable(),
                TextColumn::make('url')->url(function ($record) {
                    return $record->url;
                })->openUrlInNewTab(),
            ])
            ->filters([])->bulkActions([

                BulkAction::make('touch')->action(function (Collection $records) {
                    foreach ($records as $record) {
                        $record->touch();
                    }
                })->icon('heroicon-o-cog')->deselectRecordsAfterCompletion(),

                BulkAction::make('delete')
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion()
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-trash')

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookmarks::route('/'),
            'create' => Pages\CreateBookmark::route('/create'),
            'edit' => Pages\EditBookmark::route('/{record}/edit'),
        ];
    }
}
