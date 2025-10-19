<?php

namespace App\Filament\Resources\MoneyMovements\Pages;

use App\Filament\Resources\MoneyMovements\MoneyMovementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMoneyMovements extends ListRecords
{
    protected static string $resource = MoneyMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
