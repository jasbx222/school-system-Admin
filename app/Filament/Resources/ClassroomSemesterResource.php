<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomSemesterResource\Pages;
use App\Models\ClassRoom;
use App\Models\ClassroomSemester;
use App\Models\Semester;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClassroomSemesterResource extends Resource
{
    protected static ?string $model = ClassroomSemester::class;
protected static ?string $navigationGroup = 'ادارة الطلاب ';
    public static function getModelLabel(): string
    {
        return 'تكاليف الفصول الدراسية';
    }

    protected static ?string $pluralLabel =  'بيانات';

    protected static ?int $navigationSort = 6;

    public static ?string $navigationLabel =  'تكاليف الفصول الدراسية';
// protected static ?string $navigationGroup = 'الادارة ';

    protected static ?string $navigationIcon = 'heroicon-o-ellipsis-horizontal-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('semester_id')
                    ->label('الفصل الدراسي')
                    ->options(function () {
                        return Semester::pluck('title', 'id');
                    })
                    ->required(),
                Select::make('class_room_id')
                    ->label('الصف')
                    ->options(function () {
                        if ($schoolId = Auth::user()->school_id) {
                            return ClassRoom::where('school_id', $schoolId)->pluck('title', 'id');
                        } else {
                            return ClassRoom::pluck('title', 'id');
                        }
                    })
                    ->required(),
                TextInput::make('cost')
                    ->label('التكلفة')
                    ->numeric()
                    ->type('decimal')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('semester.title')->label('الفصل الدراسي')->searchable(),
                TextColumn::make('classRoom.title')->label('الصف'),
                TextColumn::make('cost')->label('التكلفة')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListClassroomSemesters::route('/'),
            'create' => Pages\CreateClassroomSemester::route('/create'),
            'edit' => Pages\EditClassroomSemester::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if ($schoolId = Auth::user()->school_id) {
            $classRoomIds = ClassRoom::where('school_id', $schoolId)->pluck('id');
            return parent::getEloquentQuery()->whereIn('class_room_id', $classRoomIds);
        } else {
            return parent::getEloquentQuery();
        }
    }
}
