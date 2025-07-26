<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SemesterResource\Pages;
use App\Models\Semester;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SemesterResource extends Resource
{
    protected static ?string $model = Semester::class;

    protected static ?int $navigationSort = 5;
protected static ?string $navigationGroup = 'ادارة الطلاب ';
    public static ?string $navigationLabel =  'الفصول الدراسية';
// protected static ?string $navigationGroup = 'الادارة ';
    protected static ?string $pluralLabel =  'بيانات';

    public static function getModelLabel(): string
    {
        return 'الفصول الدراسية';
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('الاسم')->required()->columnSpanFull(),
              Select::make('school_id')
    ->label('المدرسة')
    ->options(function () {
        return \App\Models\School::whereNotNull('title')->pluck('title', 'id'); // استخدم title إذا كان هو العمود الصحيح
    })
    ->searchable()
    ->required(),


                DatePicker::make('from')->label('من تاريخ')->required(),
                DatePicker::make('to')->label('إلى تاريخ')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('title')->label('الاسم')->searchable(),
                TextColumn::make('from')->label('من تاريخ'),
                TextColumn::make('to')->label('إلى تاريخ'),
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
            'index' => Pages\ListSemesters::route('/'),
            'create' => Pages\CreateSemester::route('/create'),
            'edit' => Pages\EditSemester::route('/{record}/edit'),
        ];
    }
}
