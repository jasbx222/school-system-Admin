<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoxResource\Pages;
use App\Models\Box;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class BoxResource extends Resource
{
        protected static bool $shouldRegisterNavigation = true;
    protected static ?string $model = Box::class;
      public static function shouldRegisterNavigation(): bool
{
     if(!Auth::user()->roles->contains('name', 'super_admin')) {
        return true;
    }
    return false;
}
    public static ?string $navigationLabel =  ' صندوق المصاريف';
protected static ?string $navigationGroup = 'ادارة المصاريف ';
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
  public static function getModelLabel(): string
    {
        return 'رصيد الصندوق ';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')->label('المجموع')->required(),
                Select::make('school_id')
                    ->label('المدرسة')
                    ->required()
                    ->searchable()
                    ->options(function () {
                        $user = auth()->user();
                        return \App\Models\School::where('id', $user->school_id)->pluck('title', 'id');
                    })
                    ->default(fn () => auth()->user()->school_id),
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
       Tables\Columns\TextColumn::make('amount')
    ->label('مجموع الصندوق')
    ->formatStateUsing(function ($state) {
        // تأكد من أن القيمة عددية
        $number = number_format($state); // يفصل بالألف (مثلاً: 1,234,567)

        $western = ['0','1','2','3','4','5','6','7','8','9'];
        $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];

        return str_replace($western, $arabic, $number);
    })

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBoxes::route('/'),
            'create' => Pages\CreateBox::route('/create'),
            'edit' => Pages\EditBox::route('/{record}/edit'),
        ];
    }
}
