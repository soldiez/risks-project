<?php

namespace App\Orchid\Screens\Risk;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;

class RiskListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Профиль рисков';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [

        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make()
                ->name(__('Создать риск'))
                ->icon('pencil')
                ->type(Color::DEFAULT())
                ->route('platform.risk.edit')
        ];
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
