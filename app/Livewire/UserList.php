<?php

namespace App\Livewire;

use App\Actions\User\DeleteUserByUuid;
use App\Contracts\Livewire\SimpleTablePage;
use App\Models\User;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserList extends SimpleTablePage
{
    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Action::make('go-to-dashboard')
                    ->url(route('dashboard')),
            ])
            ->columns([
                TextColumn::make('uuid'),
                TextColumn::make('gender'),
                TextColumn::make('full_name'),
                TextColumn::make('parsed_location')
                    ->label('Location')
                    ->listWithLineBreaks(),
                TextColumn::make('age'),
            ])
            ->actions([
                DeleteAction::make('delete')
                    ->icon('heroicon-o-trash')
                    ->action(fn (DeleteUserByUuid $deleteUserAction, User $record) => $deleteUserAction->execute($record->uuid)),
            ])
            ->query(
                User::query()
            );
    }
}
