<?php

namespace App\Orchid\Screens\Unit;

use Orchid\Screen\Screen;

class UnitJobPositionListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'UnitJobPositionListScreen';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [];
    }
}
