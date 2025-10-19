<?php

namespace App\Filament\Filters;

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;


class MoneyMovementDateFilter
{

    public static function make(): Filter
    {

        return Filter::make('movement_date')
            ->schema([
                DatePicker::make('created_from'),
                DatePicker::make('created_until'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['created_from'],
                        fn(Builder $query, $date): Builder => $query->whereDate('movement_date', '>=', $date),
                    )
                    ->when(
                        $data['created_until'],
                        fn(Builder $query, $date): Builder => $query->whereDate('movement_date', '<=', $date),
                    );
            })
            ->label('Fecha de Creación');
    }
}
