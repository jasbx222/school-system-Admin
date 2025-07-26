<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\ClassRoom;
use App\Models\ClassSection;
use App\Models\Invoice;
use App\Models\School;
use App\Models\Student;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?int $navigationSort = 10;
protected static ?string $navigationGroup = 'ادارة الطلاب ';
    public static ?string $navigationLabel =  'الفواتير';

    protected static ?string $pluralLabel =  'بيانات';
// protected static ?string $navigationGroup = 'الادارة ';

    public static function getModelLabel(): string
    {
        return 'الفواتير';
    }

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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

                Select::make('student_id')
                    ->label('إختر الطالب')
                    ->options(fn ($get) => $get('studentsOptions') ?: [])
                    ->required()
                    ->searchable(),
                TextInput::make('number')->label('رقم الوصل')
                    ->required(),
                TextInput::make('value')->label('قيمة الفاتورة')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('number')->label('رقم الوصل')->searchable(),
                TextColumn::make('student.full_name')->label('اسم الطالب')->searchable(),
                TextColumn::make('value')->label('قيمة الفاتورة '),
                TextColumn::make('created_at')->label('تاريخ الدفع'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
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
