<?php

namespace App\Livewire;

use App\Contracts\Livewire\SimpleTablePage;
use App\Models\User;
use Filament\Tables\Actions\Action;
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
                TextColumn::make('age'),
            ])
            ->query(
                User::query()
            );
    }
}
