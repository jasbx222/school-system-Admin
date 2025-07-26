<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryExpenseResource\Pages;
use App\Models\CategoryExpense;
use App\Models\School;
use Filament\Forms;
   use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CategoryExpenseResource extends Resource
{
    protected static ?string $model = CategoryExpense::class;
 protected static bool $shouldRegisterNavigation = true;
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

protected static ?string $navigationGroup = 'ادارة المصاريف ';
    protected static ?string $navigationLabel = 'أنواع المصاريف';
  public static function shouldRegisterNavigation(): bool
{
     if(!Auth::user()->roles->contains('name', 'super_admin')) {
        return true;
    }
    return false;
}
    public static function getModelLabel(): string
    {
        return 'نوع المصروف';
    }

    public static function getPluralModelLabel(): string
    {
        return 'أنواع المصاريف';
    }



public static function form(Form $form): Form
{
    return $form
        ->schema([
     
      Select::make('school_id')
    ->label('المدرسة')
    ->required()
    ->searchable()
    ->options(function () {
        $user = auth()->user();
        return School::where('id', $user->school_id)->pluck('title', 'id');
    }),
    
            Forms\Components\TextInput::make('title')
                ->label('عنوان المصروف')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('وصف المصروف')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull(),
        ]);
}


public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
{
    $schoolId = auth()->user()->school_id;
    $query = parent::getEloquentQuery();
    if ($schoolId) {
        $query = $query->where('school_id', $schoolId);
    }
    return $query;
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.title')
                    ->label('المدرسة')
                    ->sortable()
                    ->searchable()
                    ->extraAttributes(['class' => 'text-blue-600 font-semibold']),

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان المصروف')
                    ->searchable()
                    ->sortable()
                    ->extraAttributes(['class' => 'text-green-700 font-bold']),

                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(30)
                    ->toggleable()
                    ->extraAttributes(['class' => 'italic text-gray-600']),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->extraAttributes(['class' => 'text-gray-500']),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('تاريخ التعديل')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->extraAttributes(['class' => 'text-gray-500']),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل')->button()->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد')->color('danger'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryExpenses::route('/'),
            'create' => Pages\CreateCategoryExpense::route('/create'),
            'edit' => Pages\EditCategoryExpense::route('/{record}/edit'),
        ];
    }
}
