<?php

namespace App\Filament\Resources\MoneyMovements;

use App\Filament\Resources\MoneyMovements\Pages\CreateMoneyMovement;
use App\Filament\Resources\MoneyMovements\Pages\EditMoneyMovement;
use App\Filament\Resources\MoneyMovements\Pages\ListMoneyMovements;
use App\Filament\Resources\MoneyMovements\Pages\ViewMoneyMovement;
use App\Filament\Resources\MoneyMovements\Schemas\MoneyMovementForm;
use App\Filament\Resources\MoneyMovements\Schemas\MoneyMovementInfolist;
use App\Filament\Resources\MoneyMovements\Tables\MoneyMovementsTable;
use App\Models\MoneyMovement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MoneyMovementResource extends Resource
{
    protected static ?string $model = MoneyMovement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'movement_date';

    public static function form(Schema $schema): Schema
    {
        return MoneyMovementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MoneyMovementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MoneyMovementsTable::configure($table);
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
            'index' => ListMoneyMovements::route('/'),
            'create' => CreateMoneyMovement::route('/create'),
            'view' => ViewMoneyMovement::route('/{record}'),
            'edit' => EditMoneyMovement::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
