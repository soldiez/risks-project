<?php

namespace App\Orchid\Layouts\Risk;

use App\Models\Risk\RiskFrequency;
use App\Models\Risk\RiskSeverity;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RiskFrequencyLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'riskFrequencies';

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
                ->render(function(RiskFrequency $riskFrequency){
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make(__('Редактировать'))
                                ->modal('asyncEditRiskFrequency')
                                ->icon('note')
                                ->method('asyncEditRiskFrequency')
                                ->asyncParameters(['id' => $riskFrequency['id']]),

                            Button::make(__('Delete'))
                                ->method('removeRiskFrequency')
                                ->icon('trash')
                                ->confirm(__('Подтвердите что хотите удалить элемент'))
                                ->parameters([
                                    'id' => $riskFrequency['id'],
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
