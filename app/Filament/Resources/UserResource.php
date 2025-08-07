<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Account;
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
use Illuminate\Support\Facades\DB;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static ?string $navigationLabel = 'اضافة حساب المدرسة';
    protected static ?string $pluralLabel = 'بيانات';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'ادارة المدارس ';

    public static function getModelLabel(): string
    {
        return 'الحساب';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            DatePicker::make('expires_at')->label('تاريخ انتهاء الصلاحية'),

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
                ->options(fn() => School::pluck('title', 'id'))
                ->required()
                ->afterStateUpdated(function ($state) {
                    DB::transaction(function () use ($state) {
                        $exists = Account::where('school_id', $state)->exists();

                        if (! $exists) {
                            $jsonPath = base_path('resources/chart_of_accounts.json');


                            if (! file_exists($jsonPath)) {
                                throw new \Exception('الملف chart_of_accounts.json غير موجود في storage/app');
                            }

                            $json = json_decode(file_get_contents($jsonPath), true);
                            $accounts = $json['accounts'] ?? [];

                            // دالة recursive لإنشاء الحسابات
                            $createAccounts = function (array $accounts, int $schoolId, ?int $parentId = null) use (&$createAccounts) {
                                foreach ($accounts as $accountData) {
                                    $account = Account::create([
                                        'name'      => $accountData['name'],
                                        'code'      => $accountData['code'],
                                        'type'      => $accountData['type'] ?? null,
                                        'balance'   => 0,
                                        'school_id' => $schoolId,
                                        'parent_id' => $parentId,
                                    ]);

                                    if (! empty($accountData['children'])) {
                                        $createAccounts($accountData['children'], $schoolId, $account->id);
                                    }
                                }
                            };

                            $createAccounts($accounts, $state);
                        }
                    });
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->label('#')->sortable(),
            TextColumn::make('name')->label('الاسم')->searchable(),
            TextColumn::make('email')->label('الايميل')->searchable(),
            TextColumn::make('expires_at')->label('تاريخ انتهاء الصلاحية'),
            TextColumn::make('expires_at')
                ->label('حالة الصلاحية')
                ->color(fn(User $user) =>
                    $user->expires_at && now()->greaterThan($user->expires_at)
                        ? 'danger'
                        : 'success'
                ),
            TextColumn::make('roles.name')->label('الدور'),
        ])
        ->actions([
            Tables\Actions\EditAction::make()
                ->hidden(fn($record) => $record->roles->contains('name', 'super_admin')),
            Tables\Actions\DeleteAction::make()
                ->hidden(fn($record) => $record->roles->contains('name', 'super_admin')),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([]),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
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
