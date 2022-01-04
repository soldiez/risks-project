<?php

namespace App\Orchid\Layouts\Risk;

use App\Models\Risk\RiskSeverity;
use App\Models\Risk\RiskZone;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class RiskZoneLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'riskZones';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [

            TD::make('value', __('Значение'))->width('30%'), //TODO filling of data for matrix
            TD::make('colour', __('Цвет'))->width('10%')
                ->render(function (RiskZone $riskZone){
                    return Input::make()->type('color')->value($riskZone->colour)->readonly();
                }),
            TD::make('manage', __('Меры')),
            TD::make('info', __('Описание')),
            TD::make('')->width('20px')
                ->render(function(RiskZone $riskZone){
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make(__('Редактировать'))
                                ->modal('asyncEditRiskZone')
                                ->icon('note')
                                ->method('asyncEditRiskZone')
                                ->asyncParameters(['id' => $riskZone['id']]),

                            Button::make(__('Delete'))
                                ->method('removeRiskZone')
                                ->icon('trash')
                                ->confirm(__('Подтвердите что хотите удалить элемент'))
                                ->parameters([
                                    'id' => $riskZone['id'],
                                ]),
                        ]);
                })
        ];
    }
    protected function textNotFound(): string
    {
        return __('Здесь еще нет записей');
    }
}
