<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiverResource\Pages;
use App\Filament\Resources\ReceiverResource\RelationManagers;
use App\Models\Receiver;
use Filament\Forms;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class ReceiverResource extends Resource
{
    protected static ?string $model = Receiver::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Name')->required(),
                TextInput::make('slug')->label('Slug')
                    ->unique(ignorable: fn (?Receiver $record): ?Receiver => $record)
                    ->default(function() {
                        return Str::uuid();
                    })->disabled()->extraAttributes([
                        'class' => 'bg-gray-200',
                    ]),
                SpatieTagsInput::make('tags'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('slug')->label('Bookmark')
                    ->formatStateUsing(function($record) {
                        return $record->name;
                    })
                    ->url(function($record) {
                        $url = url("/bookmark/{$record->slug}");
                        return "javascript: (() => { window.location.href = \"{$url}?url=\" + encodeURIComponent(document.URL); })();";
                    }),
            ])
            ->filters([
                //
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
            'index' => Pages\ListReceivers::route('/'),
            'create' => Pages\CreateReceiver::route('/create'),
            'edit' => Pages\EditReceiver::route('/{record}/edit'),
        ];
    }
}
