<?php

namespace App\Orchid\Layouts\Unit;

use App\Models\Worker;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class WorkerListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'workers';


    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('')
                ->render(function ($target) {
                    return CheckBox::make($target['last_name'])
                        ->value(0);
                       //TODO массового управления строками таблицы
                })->width('5px')
            ,
            TD::make('last_name', 'Фамилия')
                ->render(function (Worker $worker) {
                    return Link::make($worker->last_name)
                        ->route('platform.worker.edit', $worker);
                })->sort()->filter(TD::FILTER_TEXT),
            TD::make('first_name', 'Имя')->sort()->filter(TD::FILTER_TEXT),
            TD::make('middle_name', 'Отчество')->filter(TD::FILTER_TEXT),
            TD::make('personnel_number', 'Табельный номер'),
            TD::make('job_position', 'Должность')->sort()->filter(TD::FILTER_TEXT),
            TD::make('department', 'Подразделение')->sort()->filter(TD::FILTER_TEXT),
            TD::make('unit_id', 'Компания')->sort()->filter(TD::FILTER_TEXT),
            TD::make('phone', 'Телефон')->filter(TD::FILTER_TEXT),
            TD::make('email', 'Почта')->filter(TD::FILTER_TEXT),
            TD::make('birthday', 'Дата рождения')->sort()->filter(TD::FILTER_TEXT),
            TD::make('created_at', 'Создано'),
            TD::make('updated_at', 'Обновлено'),
        ];
    }
    public function total():array
    {
        return [
            TD::make('total')
                ->align(TD::ALIGN_LEFT)
                ->colspan(2)
                ->render(function () {
                    return Button::make()
                        ->icon('trash')
                        ->name(__('Удалить выбранное'))
                        ->type(Color::DEFAULT())
                        ->method('deleteChoiceRows');
                }),
           ];
    }
}
