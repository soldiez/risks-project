<?php

namespace App\Orchid\Layouts\Risk;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class EditRiskZoneLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('riskMethod.id')->hidden(),
            Input::make('riskZone.risk_method_id')->hidden(),
            Input::make('riskZone.value')
                ->title(__('Значение(я)'))
                ->help(__('')),
            Input::make('riskZone.colour')
                ->title(__('Цвет'))
                ->type('color')
                ->help(__('Красный - 255,0,0, Желтый - 255,255,0, Зеленый - 0,255,0')),
            Input::make('riskZone.manage')
                ->title(__('Меры'))
                ->help(__('Рекомендуемые управляющие меры'))
                ->type('text'),
            TextArea::make('riskZone.info')
                ->title(__('Описание'))
                ->help(__('При необходимости можно добавить расширенную информацию'))
                ->rows(4),
        ];
    }
}
