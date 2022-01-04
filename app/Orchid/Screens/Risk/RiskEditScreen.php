<?php

namespace App\Orchid\Screens\Risk;

use App\Models\Risk;
use Orchid\Screen\Screen;

class RiskEditScreen extends Screen //TODO make risk edit screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание риска';
    public $exists = false;

    /**
     * Query data.
     *
     * @param Risk $risk
     * @return array
     */
    public function query(Risk $risk): array
    {
        $this->exists = $risk->exists;

        if($this->exists) {
            $this->name = 'Редактирование данных о риске';
        }
        return [
            'risk' => $risk,
        ];
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
