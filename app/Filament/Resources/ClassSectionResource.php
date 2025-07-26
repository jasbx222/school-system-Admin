<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassSectionResource\Pages;
use App\Models\ClassRoom;
use App\Models\ClassSection;
use App\Models\School;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClassSectionResource extends Resource
{
    protected static ?string $model = ClassSection::class;
    protected static ?string $navigationGroup = 'ادارة الطلاب ';
    public static ?string $navigationLabel = 'الشعب';
    public static function getModelLabel(): string { return 'الشعب'; }
    protected static ?string $pluralLabel = 'بيانات';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-bars-3-center-left';

    public static function form(Form $form): Form
{
  

    return $form->schema([
        TextInput::make('title')->label('الاسم')->required(),

        Select::make('class_room_id')
            ->label('الصف')
            ->options(function () {
        return \App\Models\ClassRoom::whereNotNull('title')->pluck('title', 'id'); // استخدم title إذا كان هو العمود الصحيح
    })
            ->required(),
       Select::make('school_id')
    ->label('المدرسة')
    ->options(function () {
        return School::all()->pluck('title', 'id');
    })
    ->required(),

    ]);
}

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->label('#')->sortable(),
            TextColumn::make('title')->label('الاسم')->searchable(),
            TextColumn::make('classRoom.title')->label('الصف'),
            TextColumn::make('school.title')->label('المدرسة'),
        ])->filters([])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
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
