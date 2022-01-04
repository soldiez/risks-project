<?php

namespace App\Orchid\Screens\Action;

use Orchid\Screen\Screen;

class ActionEditScreen extends Screen //TODO make action edit screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'ActionEditScreen';

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
