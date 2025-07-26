<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassRoomResource\Pages;
use App\Models\ClassRoom;
use App\Models\School;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClassRoomResource extends Resource
{
    protected static ?string $model = ClassRoom::class;

    public static ?string $navigationLabel =  'الصفوف';
protected static ?string $navigationGroup = 'ادارة الطلاب ';
    protected static ?string $pluralLabel =  'بيانات';
// protected static ?string $navigationGroup = 'الادارة ';

    public static function getModelLabel(): string
    {
        return 'الصفوف';
    }

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('الاسم')
                    ->required(),
               Select::make('school_id')
    ->label('المدرسة')
    ->options(function () {
        return \App\Models\School::all()->pluck('title', 'id'); // أو حسب اسم العمود الفعلي
    })
    ->searchable() // اختياري: لجعل القائمة قابلة للبحث
    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('title')->label('الاسم')->searchable(),
                TextColumn::make('school.title')->label('المدرسة'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListClassRooms::route('/'),
            'create' => Pages\CreateClassRoom::route('/create'),
            'edit' => Pages\EditClassRoom::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $schoolId = Auth::user()->school_id;
        return  $schoolId
            ? parent::getEloquentQuery()->where('school_id', $schoolId)
            : parent::getEloquentQuery();
    }
}
