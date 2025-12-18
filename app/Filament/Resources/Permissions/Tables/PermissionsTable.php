<?php

namespace App\Filament\Resources\Permissions\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PermissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('guard_name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('M d, Y h:i A T')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('M d, Y h:i A T')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('roles')
                    ->label('Assigned to Roles')
                    ->getStateUsing(fn ($record) => $record->roles->pluck('name')->join(', ')),
            ]);
    }
}
