<?php

namespace App\Orchid\Layouts\Risk;

use App\Models\Risk\RiskSeverity;
use App\Models\RiskStatus;
use Illuminate\Support\Traits\EnumeratesValues;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Contracts\Fieldable;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;


class RiskStatusLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'riskStatuses';


    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [

            TD::make('name', __('Наименование'))->sort()->cantHide()->filter(TD::FILTER_TEXT),
            TD::make('')->width('20px')->cantHide()
                ->render(function ($target) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make(__('Редактировать'))
                                ->modal('asyncUpdate')
                                ->modalTitle(__('Обновить категорию риска'))
                                ->icon('note')
                                ->method('asyncUpdate')
                                ->asyncParameters(['id' => $target->id, 'name' => $target->name, 'model' => 'riskStatus']),

                            Button::make(__('Удалить'))
                                ->method('deleteRow')
                                ->icon('trash')
                                ->confirm(__('Подтвердите что хотите удалить элемент'))
                                ->parameters([
                                    'id' => $target['id'],
                                    'model' => 'riskStatus'
                                ]),
                        ]);
                })
        ];
    }
}
