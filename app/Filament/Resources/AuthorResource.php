<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Filament\Resources\AuthorResource\RelationManagers;
use App\Models\Author;
use Filament\Forms;
use Filament\Forms\Components\{Section, TextInput, Textarea};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    protected static ?string $navigationLabel = 'المؤلفون';

    protected static ?string $modelLabel = 'المؤلفون';

    protected static ?string $navigationGroup = 'المؤلفون & الناشرين';

    public static function getPluralModelLabel(): string
    {
        $label = static::$modelLabel;
        $locale = app()->getLocale();
        return $label;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('أضف مؤلفًا جديدًا')->schema([
                    TextInput::make('name')
                        ->label('اسم المؤلف')
                        ->rule('required')
                        ->required(true),
                    Textarea::make('description')
                        ->label('الوصف')
                        ->rule('required')
                        ->required(true),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable(true)->searchable()
                    ->label('اسم المؤلف'),
                TextColumn::make('description')
                    ->label('الوصف'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
