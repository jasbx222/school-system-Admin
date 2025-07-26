<?php

namespace App\Filament\Resources;

use App\Enums\Gender;
use App\Enums\StudentStatus;
use App\Enums\YesOrNoAnswer;
use App\Filament\Resources\StudentResource\Pages;
use App\Models\ClassRoom;
use App\Models\ClassSection;
use App\Models\Offer;
use App\Models\School;
use App\Models\Semester;
use App\Models\Student;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    public static ?string $navigationLabel = 'الطلاب';
protected static ?string $navigationGroup = 'ادارة الطلاب ';
    protected static ?string $pluralLabel =  'بيانات';
// protected static ?string $navigationGroup = 'الادارة ';
    public static function getModelLabel(): string
    {
        return 'الطلاب';
    }

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('full_name')->label('الاسم الكامل')->required(),
                TextInput::make('mother_name')->label('اسم الأم الكامل')->required(),
                TextInput::make('last_school')->label('المدرسة السابقة'),
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
                    }),
                Select::make('class_room_id')
                    ->label('إختر الصف:')
                    ->options(fn ($get) => $get('classRoomsOptions') ?: ClassRoom::pluck('title', 'id'))
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        $classSections = ClassSection::where('class_room_id', $state)->pluck('title', 'id')->toArray();
                        $set('classSectionsOptions', $classSections);
                    })->required(),
                Select::make('class_section_id')->label('الشعبة')
                    ->options(fn ($get) => $get('classSectionsOptions') ?: ClassSection::pluck('title', 'id'))
                    ->required(),
                Select::make('semester_id')->label('الفصل الدراسي')
                    ->options(function () {
                        return Semester::pluck('title', 'id');
                    })->required(),
                Select::make('offer_id')
                    ->label('اختر الخصم')
                    ->options(function () {
                        return Offer::pluck('title', 'id');
                    })
                    ->searchable(),
                Radio::make('status')->label('حالته الدراسية')
                    ->options([
                        StudentStatus::CONTINUOUS =>  StudentStatus::CONTINUOUS,
                        StudentStatus::DISCONTINUOUS =>  StudentStatus::DISCONTINUOUS,
                        StudentStatus::DISMISSED =>  StudentStatus::DISMISSED,
                        StudentStatus::TRANSFERRED =>  StudentStatus::TRANSFERRED,
                    ])
                    ->inline()->inlineLabel(false)->required(),
                Textarea::make('description')->label('تفاصيل')->rows(5)->cols(20)->columnSpanFull(),
                DatePicker::make('birth_day')->label('تاريخ الميلاد')->required(),
                Radio::make('gender')->label('الجنس')
                    ->options([
                        Gender::MALE =>  Gender::MALE,
                        Gender::FEMALE =>  Gender::FEMALE,
                    ])
                    ->inline()->inlineLabel(false)->required(),
                Radio::make('orphan')->label('يتيم')
                    ->options([
                        YesOrNoAnswer::YES => YesOrNoAnswer::YES,
                        YesOrNoAnswer::NO => YesOrNoAnswer::NO,
                    ])
                    ->inline()->inlineLabel(false)->required(),
                Radio::make('has_martyrs_relatives')->label('ذوي شهداء')
                    ->options([
                        YesOrNoAnswer::YES => YesOrNoAnswer::YES,
                        YesOrNoAnswer::NO => YesOrNoAnswer::NO,
                    ])
                    ->inline()->inlineLabel(false)->required(),
                FileUpload::make('file')->label('ملف')->disk('public')
                    ->acceptedFileTypes(['application/pdf']),
                FileUpload::make('profile_image_url')->label('الصورة الشخصية')->disk('public')->avatar()
                    ->required()->columnSpanFull(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ImageEntry::make('profile_image_url')->label('الصورة الشخصية')->circular()->columnSpanFull(),
                TextEntry::make('full_name')->label('الاسم الكامل'),
                TextEntry::make('mother_name')->label('اسم الأم الكامل'),
                TextEntry::make('gender')->label('الجنس'),
                TextEntry::make('birth_day')->label('تاريخ الميلاد'),
                TextEntry::make('last_school')->label('المدرسة السابقة'),
                TextEntry::make('orphan')->label('يتيم'),
                TextEntry::make('has_martyrs_relatives')->label('ذوي شهداء'),
                TextEntry::make('school.title')->label('المدرسة'),
                TextEntry::make('semester.title')->label('الفصل الدراسي'),
                TextEntry::make('classRoom.title')->label('الصف'),
                TextEntry::make('classSection.title')->label('الشعبة')->columnSpanFull(),
                TextEntry::make('cost_of_semester')->label('القسط كامل'),
                TextEntry::make('cost_of_semester_after_offer')->label('القسط بعد الخصم'),
                TextEntry::make('offer.title')->label('اسم الخصم')->default('--'),
                TextEntry::make('offer.value')->label('نسبة الخصم')->default('--'),
                TextEntry::make('sum_of_invoices')->label('المبلغ الذي تم تسديده'),
                TextEntry::make('rest_of_invoices')->label('المبلغ المستحق دفعه'),
                TextEntry::make('sum_of_attendances_with_status_false')->label('عدد أيام الغياب'),
                TextEntry::make('sum_of_attendances_with_status_true')->label('عدد أيام الحضور'),
                TextEntry::make('description')->label('التفاصيل')->columnSpanFull(),
                TextEntry::make('file')->label('ملف مرفق')
                    ->url(fn ($record) => $record->file, true)->columnSpanFull(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable()->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('profile_image_url')
                    ->label('الصورة الشخصية')
                    ->circular(),
                TextColumn::make('full_name')->label('الاسم الكامل')->searchable(),
                TextColumn::make('mother_name')->label('اسم الأم ')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')->label('الحالة')
                    ->toggleable()
                    ->color(fn (string $state): string => match ($state) {
                        StudentStatus::CONTINUOUS => 'success',
                        StudentStatus::DISCONTINUOUS => 'warning',
                        StudentStatus::DISMISSED => 'danger',
                        StudentStatus::TRANSFERRED => 'info',
                    }),
                TextColumn::make('gender')->label('الجنس')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('orphan')->label('يتيم')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color(fn (string $state): string => match ($state) {
                        YesOrNoAnswer::YES =>  'warning',
                        YesOrNoAnswer::NO =>  'info',
                    }),
                TextColumn::make('has_martyrs_relatives')->label('ذوي شهداء')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color(fn (string $state): string => match ($state) {
                        YesOrNoAnswer::YES =>  'warning',
                        YesOrNoAnswer::NO =>  'info',
                    }),
                TextColumn::make('last_school')->label('المدرسة السابقة')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('school.title')->label('المدرسة')->toggleable(),
                TextColumn::make('classRoom.title')->label('الصف')->toggleable(),
                TextColumn::make('classSection.title')->label('الشعبة'),
                TextColumn::make('semester.title')->label('الفصل الدراسي')->toggleable(),
                TextColumn::make('cost_of_semester_after_offer')->label('القسط')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('invoices_sum_value')->sum('invoices', 'value')->label('ماتم تسديده')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sum_of_attendances_with_status_false')->label('عدد أيام الغياب')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sum_of_attendances_with_status_true')->label('عدد أيام الحضور')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('birth_day')->label('تاريخ الميلاد')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')->label('التفاصيل')->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('الفواتير')
                    ->icon('heroicon-o-banknotes')
                    ->url(fn (Student $record): string =>  self::getUrl('invoices', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
            'invoices' => Pages\StudentInvoices::route('/{record}/invoices'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $schoolId = Auth::user()->school_id;
        return $schoolId
            ? parent::getEloquentQuery()->where('school_id', $schoolId)
            : parent::getEloquentQuery();
    }
}
