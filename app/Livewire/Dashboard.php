<?php

namespace App\Livewire;

use App\Contracts\Livewire\SimpleTablePage;
use App\Contracts\Repositories\RandomUserRepository;
use App\Models\DailyRecord;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class Dashboard extends SimpleTablePage
{
    public function table(Table $table): Table
    {
        $repository = resolve(RandomUserRepository::class);
        $repository->get();
        return $table
            ->headerActions([
                Action::make('go-to-user-list')
                    ->url(route('user.list')),
            ])
            ->columns([
                TextColumn::make('date'),
                TextColumn::make('male_count'),
                TextColumn::make('female_count'),
                TextColumn::make('male_avg_age'),
                TextColumn::make('female_avg_age'),
            ])
            ->query(
                DailyRecord::query()
            );
    }
}
