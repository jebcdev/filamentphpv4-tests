<?php

namespace App\Filament\Resources\MoneyMovements\Pages;

use App\Filament\Resources\MoneyMovements\MoneyMovementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMoneyMovement extends ViewRecord
{
    protected static string $resource = MoneyMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
