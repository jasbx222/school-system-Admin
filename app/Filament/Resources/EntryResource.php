<?php

namespace App\Filament\Resources;

use App\Models\Entry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EntryResource extends Resource
{
    protected static ?string $model = Entry::class;
    public static ?string $navigationLabel = 'القيود';
    protected static ?string $navigationGroup = 'ادارة المصاريف';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    public static function getModelLabel(): string
    {
        return 'القيود المحاسبية';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                Placeholder::make('id')
                    ->label('رقم القيد')
                    ->content(fn ($record) => $record->id),

                Placeholder::make('box_id')
                    ->label('الصندوق ')
                    ->content(fn ($record) => $record->box?->id ?? '-'),

              Placeholder::make('expense_title')
    ->label('المصروف (حسب نوع القيد)')
    ->content(function ($record) {
        $title = $record->expense?->title ?? '-';

        if ($record->type === 'debit') {
            $boxType = '(مدين)';
            $expenseType = '(دائن)';
        } elseif ($record->type === 'credit') {
            $boxType = '(دائن)';
            $expenseType = '(مدين)';
        } else {
            $boxType = '';
            $expenseType = '';
        }

        return "الصندوق {$boxType} - {$title} {$expenseType}";
    }),

                Placeholder::make('type')
                    ->label('نوع القيد')
                    ->content(fn ($record) => [
                        'debit' => 'مدين',
                        'credit' => 'دائن',
                    ][$record->type] ?? '-'),

                Placeholder::make('amount')
                    ->label('المبلغ')
                    ->content(fn ($record) => number_format($record->amount)),

                Placeholder::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->content(fn ($record) => $record->created_at?->format('Y-m-d H:i:s') ?? '-'),
            ]),

            Placeholder::make('description')
                ->label('الوصف')
                ->content(fn ($record) => $record->description)
                ->columnSpan('full'),

            Placeholder::make('double_entry_note')
                ->label('تفصيل القيد ')
                ->content(function ($record) {
                    if (!$record) return '-';

                    $amount = number_format($record->amount);
                    $expense = $record->expense?->title ?? 'المصروف';
                    $box = $record->box?->id ? "الصندوق رقم {$record->box->id}" : 'الصندوق';

                    // تحديد حالة القيد: مدين (قبض) أو دائن (دفع)
                  $isDebit = ($record->type === 'debit');

if ($isDebit) {
    // قبض: من حساب المصروف (الطلاب) إلى الصندوق
    return "من حساب {$expense} إلى حساب {$box} بمبلغ {$amount} د.ع (قبض)";
} else {
    // دفع: من الصندوق إلى حساب المصروف (الطلاب)
    return "من حساب {$box} إلى حساب {$expense} بمبلغ {$amount} د.ع (دفع)";
}

                })
                ->columnSpan('full')
                ->hidden(fn ($record) => !$record),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('رقم القيد')->sortable(),
                Tables\Columns\TextColumn::make('box.id')->label('رقم الصندوق')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('expense.title')->label('المصروف')->sortable()->searchable()->limit(30),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع القيد')
                    ->formatStateUsing(fn ($state) => [
                        'debit' => 'مدين',
                        'credit' => 'دائن',
                    ][$state] ?? $state),
                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        $number = number_format($state);
                        $western = ['0','1','2','3','4','5','6','7','8','9'];
                        $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
                        return str_replace($western, $arabic, $number);
                    }),
                Tables\Columns\TextColumn::make('description')->label('الوصف')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('تفاصيل')
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف'),
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
            'index' => \App\Filament\Resources\EntryResource\Pages\ListEntries::route('/'),
            'edit' => \App\Filament\Resources\EntryResource\Pages\EditEntry::route('/{record}'),
        ];
    }
}
