<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\UnitTerritoryFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class UnitTerritorySelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            UnitTerritoryFilter::class
        ];
    }
}
