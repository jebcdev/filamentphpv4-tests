<?php

namespace App\Filament\Resources\MoneyMovements\Schemas;

use App\Models\MoneyMovement;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MoneyMovementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User')
                    ->placeholder('-'),
                TextEntry::make('movement_date')
                    ->date(),
                TextEntry::make('description'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('type'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (MoneyMovement $record): bool => $record->trashed()),
            ]);
    }
}
