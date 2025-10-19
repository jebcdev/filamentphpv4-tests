<?php

namespace App\Filament\Resources\MoneyMovements\Tables;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Filters\MoneyMovementDateFilter;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;

use Filament\Actions\DeleteBulkAction;

use Illuminate\Database\Query\Builder;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Grouping\Group as TableGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Support\Facades\DB;



class MoneyMovementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('user.name')
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('movement_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Cantidad')
                    ->numeric()
                    ->searchableAndSortable()
                    ->summarize([
                        Sum::make()
                            ->label('Total Ingresos')
                            ->query(fn(Builder $query) => $query->where('type', 'income')),
                        Sum::make()
                            ->label('Total Gastos')
                            ->query(fn(Builder $query) => $query->where('type', 'expense')),
                        Summarizer::make()
                            ->label('Diferencia (Ingresos - Gastos)')
                            ->using(fn(Builder $query) => $query->sum(DB::raw("CASE WHEN type = 'income' THEN amount ELSE -amount END"))),
                    ]),

                TextColumn::make('type')
                    ->summarize([
                        Count::make()
                            ->label('Cantidad de Ingresos')
                            ->query(fn(Builder $query) => $query->whereIn('type', ['income'])),
                        Count::make()
                            ->label('Cantidad de Gastos')
                            ->query(fn(Builder $query) => $query->whereIn('type', ['expense'])),
                    ])
                    ->searchableAndSortable(),

                TextColumn::make('description')
                    ->searchableAndSortable(),



                TextColumn::make('created_at')
                    ->dateTime()
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->searchableAndSortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->groups([
                TableGroup::make('movement_date')->label('Fecha de Movimiento'),
                TableGroup::make('type')->label('Tipo de Movimiento'),
            ])
            // ->defaultGroup('movement_date')
            ->filters([
                TrashedFilter::make(),
                MoneyMovementDateFilter::make(),

            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make(),


            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')

                /*  */
            ])
            ->toolbarActions([
                FilamentExportBulkAction::make('Export'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                    ForceDeleteBulkAction::make(),

                    RestoreBulkAction::make(),

                ])

            ]);
    }
}
