<?php

namespace App\Filament\Resources\MoneyMovements\Pages;

use App\Filament\Resources\MoneyMovements\MoneyMovementResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMoneyMovement extends EditRecord
{
    protected static string $resource = MoneyMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
