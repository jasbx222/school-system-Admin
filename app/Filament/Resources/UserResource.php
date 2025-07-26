<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\School;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static ?string $navigationLabel = 'اضافة حساب المدرسة';

    protected static ?string $pluralLabel =  'بيانات';

    public static function getModelLabel(): string
    {
        return 'الحساب';
    }

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
protected static ?string $navigationGroup = 'ادارة المدارس ';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                   DatePicker::make('expires_at')
                ->label('تاريخ انتهاء الصلاحية'),
                TextInput::make('name')
                    ->label('الاسم')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('الايميل')
                    ->required()
                    ->email()
                    ->maxLength(255),
                Select::make('roles')
                    ->label('الدور')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable(),
                TextInput::make('password')
                    ->label('كلمة السر')
                    ->required()
                    ->password()
                    ->revealable()
                    ->maxLength(255),
                Select::make('school_id')
                    ->label('المدرسة')
                    ->options(function () {
                        return School::pluck('title', 'id');
                    })
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('name')->label('الاسم')->searchable(),
                TextColumn::make('email')->label('الايميل')->searchable(),
                TextColumn::make('expires_at')->label('تاريخ انتهاء الصلاحية'),
             TextColumn::make('expires_at')
                ->label('انتهاء الصلاحية')
                ->color(fn (User $user) =>
                  $user && $user->expires_at && now()->greaterThan($user->expires_at)
                        ? 'danger'
                        : 'success'
                ),
                TextColumn::make('roles.name')->label('الدور'),
            ])
            ->filters([
                //
            ])
          ->actions([
    Tables\Actions\EditAction::make()->hidden(fn ($record) => isset($record->roles[1]) && $record->roles[1]['name'] === 'super_admin'),
    Tables\Actions\DeleteAction::make()->hidden(fn ($record) => isset($record->roles[1]) && $record->roles[1]['name'] === 'super_admin'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
