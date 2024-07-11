<?php

namespace App\Livewire;

use App\Actions\User\DeleteUserByUuid;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class UserList extends SimpleTablePage
{
    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Action::make('go-to-dashboard')
                    ->url(route('dashboard')),
            ])
            ->filters([
                SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_at'),
                    ])
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['created_at']) {
                            return null;
                        }

                        return 'Created at '.Carbon::parse($data['created_at'])->toFormattedDateString();
                    })
                    ->query(fn (Builder $query, array $data): Builder => ! $data['created_at'] ? $query : $query->whereDate('created_at', $data['created_at'])),
            ])
            ->columns([
                TextColumn::make('uuid')->searchable(),
                TextColumn::make('gender'),
                TextColumn::make('full_name')
                    ->searchable(
                        query: fn (Builder $query, string $search) => $query->whereRaw("lower(name->>'first'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("lower(name->>'last'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("lower(name->>'title'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("concat(lower(name->>'title'::text),lower(name->>'first'::text), lower(name->>'last'::text)) like lower(?)", '%'.$search.'%')
                    ),
                TextColumn::make('parsed_location')
                    ->label('Location')
                    ->listWithLineBreaks()
                    ->searchable(
                        query: fn (Builder $query, string $search) => $query->whereRaw("lower(location->>'city'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("lower(location->>'state'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("lower(location->'street'->>'name'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("lower(location->'street'->>'number'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("concat(lower(location->'street'->>'name'::text), lower(location->'street'->>'number'::text)) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("lower(location->>'country'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("lower(location->>'postcode'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("lower(location->'timezone'->>'description'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("lower(location->'timezone'->>'offset'::text) like lower(?)", '%'.$search.'%')
                            ->orWhereRaw("concat(lower(location->'timezone'->>'description'::text), lower(location->'timezone'->>'offset'::text)) like lower(?)", '%'.$search.'%')
                    ),
                TextColumn::make('age'),
                TextColumn::make('created_at'),
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
