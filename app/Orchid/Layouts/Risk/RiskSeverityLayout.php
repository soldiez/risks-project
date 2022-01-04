<?php

namespace App\Orchid\Layouts\Risk;

use App\Models\Risk\RiskSeverity;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;


class RiskSeverityLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'riskSeverities';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [

            TD::make('name', __('Наименование'))->width('30%'),
            TD::make('value', __('Значение'))->width('10%'),
            TD::make('info', __('Описание')),
            TD::make('')->width('20px')
            ->render(function(RiskSeverity $riskSeverity){
                return DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        ModalToggle::make(__('Редактировать'))
                            ->modal('asyncEditRiskSeverity')
                            ->icon('note')
                            ->method('asyncEditRiskSeverity')
                        ->asyncParameters(['id' => $riskSeverity['id']]),

                        Button::make(__('Delete'))
                            ->method('removeRiskSeverity')
                            ->icon('trash')
                            ->confirm(__('Подтвердите что хотите удалить элемент'))
                            ->parameters([
                                'id' => $riskSeverity['id'],
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
