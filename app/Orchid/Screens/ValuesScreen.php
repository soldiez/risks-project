<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;

class ValuesScreen extends Screen
{ //TODO сделать экран с параметрами
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список параметров';
    public $description = 'Перечень постоянных параметров';

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
