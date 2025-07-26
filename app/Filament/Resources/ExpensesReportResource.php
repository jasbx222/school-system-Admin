<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpensesReportResource\Pages;
use App\Models\ExpensesReport;
use App\Exports\ExpensesReportsExport;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExpensesReportResource extends Resource
{
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $model = ExpensesReport::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
  protected static ?string $navigationGroup = 'ادارة المصاريف ';
  
    public static ?string $navigationLabel =  'تقارير المصاريف';
   public static function getModelLabel(): string
    {
        return 'تقاير المصاريف';
    }
      public static function shouldRegisterNavigation(): bool
{
     if(!Auth::user()->roles->contains('name', 'super_admin')) {
        return true;
    }
    return false;
}

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('expense_id')
                ->label('المصروف')
                ->relationship('expense', 'title')
                ->required(),
        ]);
    }

   public static function table(Table $table): Table
{
    return $table->columns([
        Tables\Columns\TextColumn::make('expense.title')->label('عنوان المصروف'),
        Tables\Columns\TextColumn::make('expense.amount')->label('المبلغ'),
        Tables\Columns\TextColumn::make('expense.date')->label('تاريخ المصروف')->date(),
        Tables\Columns\TextColumn::make('expense.school.title')->label(' المدرسة'),
        Tables\Columns\TextColumn::make('expense.description')->label('الوصف'),
        Tables\Columns\TextColumn::make('expense.category_expense.title')->label('تصنيف المصروف'),

        Tables\Columns\TextColumn::make('created_at')->label('تاريخ التقرير')->date(),

    ])
    ->actions([
        Tables\Actions\EditAction::make()->label('تعديل'),
    ])
    ->bulkActions([
        Tables\Actions\DeleteBulkAction::make()->label('حذف'),
    ])
    ->headerActions([
        Action::make('export')
            ->label('تصدير Excel')

            ->action(function () {
                return Excel::download(new ExpensesReportsExport, 'تقارير-المصاريف.xxls');
            }),
    ]);
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpensesReports::route('/'),
            'create' => Pages\CreateExpensesReport::route('/create'),
            'edit' => Pages\EditExpensesReport::route('/{record}/edit'),
        ];
    }
}
