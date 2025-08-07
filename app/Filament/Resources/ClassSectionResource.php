<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassSectionResource\Pages;
use App\Models\ClassRoom;
use App\Models\ClassSection;
use App\Models\School;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClassSectionResource extends Resource
{
    protected static ?string $model = ClassSection::class;

    protected static ?string $navigationGroup = 'ادارة الطلاب ';
    protected static ?string $navigationLabel = 'الشعب';
    protected static ?string $navigationIcon = 'heroicon-o-bars-3-center-left';
    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return 'الشعبة';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('اسم الشعبة')
                ->required(),

            Select::make('class_room_id')
                ->label('الصف')
                ->options(fn () => ClassRoom::pluck('title', 'id'))
                ->searchable()
                ->required(),

            
            Select::make('school_id')
                ->label('المدرسة')
                ->options(fn () => School::pluck('title', 'id'))
                ->searchable()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('title')->label('اسم الشعبة')->searchable(),
                TextColumn::make('classRoom.title')->label('الصف'),
                TextColumn::make('school.title')->label('المدرسة'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassSections::route('/'),
            'create' => Pages\CreateClassSection::route('/create'),
            'edit' => Pages\EditClassSection::route('/{record}/edit'),
        ];
    }
}
