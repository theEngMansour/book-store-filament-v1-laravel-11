<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublisherResource\Pages;
use App\Filament\Resources\PublisherResource\RelationManagers;
use App\Models\Publisher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{Section, TextInput, Textarea};
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PublisherResource extends Resource
{
    protected static ?string $model = Publisher::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationLabel = 'الناشرين';

    protected static ?string $modelLabel = 'الناشرين';

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
                Section::make('أضف ناشرًا جديدًا')->schema([
                    TextInput::make('name')
                        ->label('اسم الناشر')
                        ->rule('required')
                        ->required(true),
                    TextInput::make('address')
                        ->label('العنوان')
                        ->rule('required')
                        ->required(true),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable(true)->searchable()
                    ->label('اسم الناشر'),
                TextColumn::make('address')
                    ->label('العنوان'),
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
            'index' => Pages\ListPublishers::route('/'),
            'create' => Pages\CreatePublisher::route('/create'),
            'edit' => Pages\EditPublisher::route('/{record}/edit'),
        ];
    }
}
