<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Models\Offer;
use App\Models\School;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;
    protected static ?string $navigationGroup = 'ادارة الطلاب ';
    public static ?string $navigationLabel = 'الخصومات';
    public static function getModelLabel(): string
    {
        return 'الخصومات';
    }
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('الاسم')->required(),
                TextInput::make('value')->label('قيمة الخصم كنسبة مئوية')->required(),
                Select::make('school_id')->label('المدرسة')->required()->searchable()->options(School::pluck('title', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('title')->label('الاسم')->searchable(),
                TextColumn::make('value')->label('قيمة الخصم كنسبة مئوية'),
                TextColumn::make('school.title')->label('المدرسة')->sortable()->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
