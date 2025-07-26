<?php

namespace App\Filament\Resources;

use App\Exports\StudentsExport;
use App\Filament\Resources\SchoolResource\Pages;
use App\Models\School;
use App\Models\Student;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;
protected static ?string $navigationGroup = 'ادارة المدارس ';
    public static ?string $navigationLabel =  'المدارس';

    protected static ?string $pluralLabel =  'بيانات';

    public static function getModelLabel(): string
    {
        return 'المدارس';
    }

    protected static ?int $navigationSort = 2;


    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('الاسم')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('title')->label('الاسم')->searchable(),
                TextColumn::make('count_of_male_student')->label('عدد الذكور')->toggleable(),
                TextColumn::make('count_of_female_student')->label('عدد الإناث')->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('تصدير')
                    ->action(function ($record) {
                        $students = Student::where('school_id', $record->id)->get();
                        return Excel::download(new StudentsExport($students, $record->id), date('Y-m-d') . '-' . $record->title . '-school-export.xlsx');
                    })->icon('heroicon-o-arrow-down-on-square'),

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
            'index' => Pages\ListSchools::route('/'),
            'create' => Pages\CreateSchool::route('/create'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        $schoolId = Auth::user()->school_id;
        return $schoolId
            ? Parent::getEloquentQuery()->where('id', $schoolId)
            : parent::getEloquentQuery();
    }
}
