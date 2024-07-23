<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\{
    DatePicker,
    FileUpload,
    Grid,
    Group,
    Section,
    Select,
    TextInput,
    Textarea,
    Toggle
};
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'الكتب';

    protected static ?string $modelLabel = 'الكتب';

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
                Grid::make(
                    [
                        'default' => 1,
                        'md' => 3,
                    ]
                )->schema([
                    Group::make()->schema([
                        Section::make('أضف تصنيفًا جديدًا')->schema([
                            TextInput::make('title')
                                ->label('عنوان الكتاب')
                                ->rule('required')
                                ->required(true),
                            TextInput::make('isbn')
                                ->numeric()
                                ->label('الرقم التسلسلي')
                                ->rule('required')
                                ->required(true),
                            FileUpload::make('cover_image')
                                ->label('صورة الكتاب')
                                ->rule('required')
                                ->required(true)
                                ->columnSpanFull(),
                            Select::make('category_id')
                                ->relationship(name: 'category', titleAttribute: 'name')
                                ->searchable('name')
                                ->label('التصنيفات')
                                ->rule('required')
                                ->columnSpanFull()
                                ->required(true),
                            Select::make('publisher_id')
                                ->relationship(name: 'publisher', titleAttribute: 'name')
                                ->searchable('name')
                                ->label('الناشر')
                                ->rule('required')
                                ->required(true),
                            Select::make('authors_id')
                                ->relationship(name: 'authors', titleAttribute: 'name')
                                ->searchable('name')
                                ->multiple()
                                ->label('المؤلفون')
                                ->rule('required')
                                ->required(true),
                            DatePicker::make('publish_year')
                                ->label('سنة النشر')
                                ->rule('required')
                                ->required(true),
                            TextInput::make('number_of_pages')
                                ->numeric()
                                ->label('عدد الصفحات')
                                ->rule('required')
                                ->required(true),
                            TextInput::make('number_of_copies')
                                ->numeric()
                                ->label('عدد النسخ')
                                ->rule('required')
                                ->required(true),
                            TextInput::make('price')
                                ->numeric()
                                ->label('السعر')
                                ->suffix('ريال')
                                ->rule('required')
                                ->required(true),
                        ])->columns(2),
                    ])->columnSpan([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                    Group::make()->schema([
                        Section::make('خصائص')->schema([
                            Toggle::make('is_visible')
                                ->label('مرئي')
                                ->onColor('success')
                                ->offColor('danger')
                                ->helperText('كتاب هذا مرئي لجميع')
                        ])
                    ])->columnSpan([
                        'default' => 1,
                        'sm' => 1,
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('معرف الكتاب'),
                ImageColumn::make('cover_image')->label('صورة الكتاب'),
                TextColumn::make('title')->label('عنوان الكتاب'),
                TextColumn::make('isbn')->label('الرقم التسلسلي'),
                TextColumn::make('category.name')->label('التصنيفات'),
                TextColumn::make('publisher.name')->label('الناشر'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make(
                    [
                        Tables\Actions\Action::make('edit')
                            ->url(fn (Book $book): string => '/admin/book/'. $book->id)
                            ->label('عرض')
                        ,
                        Tables\Actions\EditAction::make()->icon(''),
                        Tables\Actions\DeleteAction::make()->icon('')
                    ]
                )
                // ,
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
            'index' => Pages\ListBooks::route('/'),
            'View' => Pages\View::route('/{record}'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
