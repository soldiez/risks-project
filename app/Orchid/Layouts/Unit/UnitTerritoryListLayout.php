<?php

namespace App\Orchid\Layouts\Unit;

use App\Models\Unit;
use App\Models\Unit\UnitTerritory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class UnitTerritoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'territories';

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
                    return CheckBox::make($target['id'])->value(0);
                })->width('5px')->cantHide(),
            TD::make('id')->canSee(0),
            TD::make('unit_id', __('Предприятие'))->sort()->filter(TD::FILTER_TEXT)
                ->render(function ($target){
                    if($target->unit_id > 0) {
                        $parentCategory = Unit::find($target->unit_id);
                        return $parentCategory->short_name;
                    }
                    return __('-');}
                ),
            TD::make('parent_id', __('Территория'))->sort()
                ->render(function ($target){
                    if($target->parent_id > 0) {
                        $parentCategory = UnitTerritory::find($target->parent_id);
                        return $parentCategory->name;
                    }
                    return __('-');}
                ),
            TD::make('name', __('Наименование'))->sort()->filter(TD::FILTER_TEXT)->cantHide(),
            TD::make('responsible_id', __('Ответственный'))->sort()->filter(TD::FILTER_TEXT)->canSee(0),
            TD::make('unit_department_id', __('Подразделение'))->sort()->filter(TD::FILTER_TEXT)->canSee(0),
            TD::make('coordinate', __('Координаты'))->sort()->filter(TD::FILTER_TEXT)->canSee(0),
            TD::make('address', __('Адрес'))->sort()->filter(TD::FILTER_TEXT)->canSee(0),
            TD::make('info', __('Информация'))->canSee(0),
            TD::make('')->cantHide()->render(function ($target){
                return ModalToggle::make(__('Редактировать'))
                    ->modal('asyncCategoryModal')
                    ->modalTitle(__('Обновить запись'))
                    ->icon('note')
                    ->method('updateCategoryModal')
                    ->asyncParameters([
                        'id' => $target->id,
                        'unit_id' => $target->unit_id,
                        'parent_id' => $target->parent_id,
                        'name' => $target->name,
                    ]);
            })
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
                        ->confirm(__('Внимание - удалятся все вложенные элементы.'))
                        ->method('deleteChoiceRows');
                }),
        ];
    }
}
