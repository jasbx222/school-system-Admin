<?php

namespace App\Filament\Resources;

use App\Enums\AttendanceStatus;
use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\ClassSection;
use App\Models\School;
use App\Models\Student;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;
protected static ?string $navigationGroup = 'ادارة الطلاب ';
    public static ?string $navigationLabel =  'تفقد الحضور';

    public static function getModelLabel(): string
    {
        return 'التفقدات';
    }

    protected static ?string $pluralLabel =  'بيانات';
// protected static ?string $navigationGroup = 'الادارة ';


    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    public static function form(Form $form): Form
    {

        if ($form->getOperation() === 'create') {
            $form->schema([
                Select::make('school_id')
                    ->label('إختر المدرسة')
                    ->options(function () {
                        $schoolId = Auth::user()->school_id;
                        return  $schoolId
                            ? School::where('id', $schoolId)->pluck('title', 'id')
                            : School::pluck('title', 'id');
                    })
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        $classRooms = ClassRoom::where('school_id', $state)->pluck('title', 'id')->toArray();
                        $set('classRoomsOptions', $classRooms);
                    })
                    ->required(),
                Select::make('class_room_id')
                    ->label('إختر الصف:')
                    ->options(fn ($get) => $get('classRoomsOptions') ?: [])
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        $classSections = ClassSection::where('class_room_id', $state)->pluck('title', 'id')->toArray();
                        $set('classSectionsOptions', $classSections);
                    })
                    ->required(),
                Select::make('class_section_id')
                    ->label('إختر الشعبة')
                    ->options(fn ($get) => $get('classSectionsOptions') ?: [])
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        $students = Student::where('class_section_id', $state)->pluck('full_name', 'id')->toArray();
                        $set('studentsOptions', $students);
                    })
                    ->required(),
                CheckboxList::make('student_ids')
                    ->label('الطلاب')
                    ->reactive()
                    ->options(fn ($get) => $get('studentsOptions') ?: [])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
        } else {
            $form->schema([
                Select::make('student_id')
                    ->label('اسم الطالب')
                    ->options(function () {
                        return Student::pluck('full_name', 'id');
                    })
                    ->required()->searchable(),
                Radio::make('status')
                    ->label('الحالة')
                    ->options([
                        AttendanceStatus::PRESENT => AttendanceStatus::PRESENT,
                        AttendanceStatus::ABSENT => AttendanceStatus::ABSENT,
                    ])
                    ->inline()->inlineLabel(false)
                    ->required(),
            ]);
        }
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('student.full_name')->label('اسم الطالب')->searchable(),
                TextColumn::make('status')->label('الحالة'),
                TextColumn::make('created_at')->label('التاريخ'),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if ($schoolId = Auth::user()->school_id) {
            $studentIds = Student::where('school_id', $schoolId)->pluck('id');
            return parent::getEloquentQuery()->whereIn('student_id', $studentIds);
        } else {
            return parent::getEloquentQuery();
        }
    }
}
