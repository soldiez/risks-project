<?php

namespace App\Orchid\Layouts\Risk;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

class CreateRiskSeverityLayout extends Rows
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
                Input::make('riskSeverity.name')
                    ->title(__('Наименование'))
                    ->help(__(''))
                    ->type('text'),
                Input::make('riskSeverity.value')
                    ->title(__('Значение'))
                    ->help(__('Цифровое значение'))
                    ->type('number'),
                TextArea::make('riskSeverity.info')
                    ->title(__('Описание'))
                    ->help(__('При необходимости можно добавить расширенную информацию'))
                    ->rows(4),
        ];
    }
}
