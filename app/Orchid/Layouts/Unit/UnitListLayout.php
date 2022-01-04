<?php

namespace App\Orchid\Layouts\Unit;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UnitListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'units';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array //TODO work with logo
    {
        return [
            TD::make('logo_unit', __('Логотип'))
            ->render(function () {

        return "<img src='http://lorempixel.com/100/50/sports/' >";
    }),


            TD::make('short_name', __('Наименование компании'))
            ->render(function ($unit){
               return Link::make($unit->short_name)
                   ->route('platform.unit.edit', $unit);
            })->sort()->filter(TD::FILTER_TEXT),
            TD::make('legal_address', __('Контакты'))
            ->render(function ($unit){
               return __("Юр.адрес: ") . $unit->legal_address . "<br>" .
                   __("Почт.адрес: ") . $unit->post_address . "<br>" .
                   __("Телефон: ") . $unit->phone_main . " " . $unit->phone_reserve . __(" Почта: ") . $unit->email;
            })->filter(TD::FILTER_TEXT),
            TD::make('unit_manager', __('Руководитель'))
            ->render(function($unit){
                return $unit->unit_manager . "<br>" .
                    $unit->unit_manager_phone . "<br> " . $unit->unit_manager_email;
            })->filter(TD::FILTER_TEXT),
            TD::make('unit_safety_manager', __('Руководитель по ОТ'))
                ->render(function($unit){
                    return $unit->unit_safety_manager . "<br>" .
                        $unit->unit_safety_manager_phone . "<br> " . $unit->unit_safety_manager_email;
                })->filter(TD::FILTER_TEXT),



            TD::make('parent_unit_id', __('Головная компания'))->sort()->filter(TD::FILTER_TEXT),
            TD::make('status', __('Статус'))->sort()->filter(TD::FILTER_TEXT),
        ];
    }
}
