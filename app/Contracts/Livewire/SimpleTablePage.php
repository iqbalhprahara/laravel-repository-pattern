<?php

namespace App\Contracts\Livewire;

use Filament\Pages\SimplePage;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

abstract class SimpleTablePage extends SimplePage implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'livewire.table';

    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::SevenExtraLarge;
    }
}
