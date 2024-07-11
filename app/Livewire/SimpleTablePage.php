<?php

namespace App\Livewire;

use Filament\Actions\Concerns\CanNotify;
use Filament\Pages\SimplePage;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

abstract class SimpleTablePage extends SimplePage implements HasTable
{
    use CanNotify, InteractsWithTable;

    protected static string $view = 'livewire.table';

    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::SevenExtraLarge;
    }

    public function getMaxContentWidth(): MaxWidth|string|null
    {
        return MaxWidth::SevenExtraLarge;
    }
}
