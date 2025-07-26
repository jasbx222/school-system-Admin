<?php 
namespace App\Filament\Resources;

use App\Enums\Payment;
use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use App\Models\School;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ExpenseResource extends Resource
{
    protected static bool $shouldRegisterNavigation = true;

  // التاكد اذا ادمن نعرض اله الصفحة في السايد بار
  public static function shouldRegisterNavigation(): bool
{
     if(!Auth::user()->roles->contains('name', 'super_admin')) {
        return true;
    }
    return false;
}

    // تحديد النموذج المرتبط بالموارد


    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static ?string $navigationLabel =  ' المصاريف';
    protected static ?string $navigationGroup = 'ادارة المصاريف ';

    public static function getModelLabel(): string
    {
        return 'المصاريف';
    }

   
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('school_id')
                    ->label('المدرسة')
                    ->options(function () {
                        $schoolId = Auth::user()->school_id;
                        if ($schoolId) {
                            return School::where('id', $schoolId)->pluck('title', 'id');
                        }
                        // لو ما مرتبط بمدرسة، جلب كل المدارس (أو ممكن تحط empty())
                        return School::pluck('title', 'id');
                    })
                    ->required()->searchable(),
             Forms\Components\Select::make('category_expense_id')
    ->label('فئة المصروف')
    ->options(function () {
        $schoolId = auth()->user()->school_id;
        return \App\Models\CategoryExpense::where('school_id', $schoolId)
            ->pluck('title', 'id')
            ->toArray();
    })
    ->required()
    ->searchable(),

                Forms\Components\TextInput::make('title')
                    ->label('عنوان المصروف')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->label('المبلغ')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('date')
                    ->label('التاريخ')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('الوصف')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Radio::make('status')
                    ->label('الحالة')
                    ->options([
                        Payment::GAVE =>  Payment::GAVE,
                        Payment::TAKE =>  Payment::TAKE,
                    ])
                    ->inline()->inlineLabel(false)
                    ->required(),
            ]);
    }
// فاكشن getEloquentQuery() لتصفية البيانات حسب المدرسة لامرتبط بها المستخدم
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
                    ->label('اسم المدرسة')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category_expense.title')
                    ->label('فئة المصروف')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان المصروف')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('التاريخ')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\Action::make('view_entry')
                    ->label('رؤية القيد')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => url('/entries/' . $record->id))
                    ->color('success')
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف'),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
