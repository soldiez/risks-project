<?php

namespace App\Orchid\Screens\Unit;

use App\Models\Unit;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class UnitEditScreen extends Screen //TODO rearrange fields in better style
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Редактирование предприятия';
    public $description = 'Редактирование параметров предприятия';

    /**
     * Query data.
     *
     * @param Unit $unit
     * @return array
     */
    public function query(Unit $unit): array
    {
        $this->exists = $unit->exists;

        if($this->exists) {
            $this->name = 'Редактирование данных о предприятии';
        }
        return [
            'unit' => $unit
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Создать предприятие')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->confirm('Подтвердите удаление')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('unit.short_name')->title(__('Короткое имя')) //TODO validate
                        ->placeholder(__('Короткое имя компании'))->required(),
                    Input::make('unit.long_name')->title(__('Полное имя'))
                        ->placeholder(__('Полное имя компании')),
                    Input::make('unit.parent_unit_id')->title(__('Родительская компания'))
                        ->placeholder(__(''))->help(__('Введите короткое имя родительской компании')), //TODO link to parent_unit_id
                    Picture::make('logo_unit')->title(__('Логотип компании')),
                ]),
                Layout::rows([
                    Input::make('unit.legal_address')->title(__('Адреса'))
                        ->placeholder(__('Юридический адрес компании')),
                    Input::make('unit.post_address')
                        ->placeholder(__('Почтовый адрес компании')),
                    Input::make('unit.phone_main')->title(__('Телефоны'))
                        ->placeholder(__('Телефон компании')),
                    Input::make('unit.phone_reserve')
                        ->placeholder(__('Резервный телефон компании')),
                    Input::make('unit.email')->title(__('Почта'))->type('email')
                        ->placeholder(__('Электронная почта')),
                ]),
            ]),

            Layout::columns([
                Layout::rows([
                    Input::make('unit.unit_manager')->title(__('Данные руководителя'))
                        ->placeholder(__('ФИО руководителя компании')),
                    Input::make('unit.unit_manager_phone')
                        ->placeholder(__('Телефон руководителя')),
                    Input::make('unit.unit_manager_email')
                        ->placeholder(__('Почта руководителя'))->type('email')
                ]),
                Layout::rows([
                    Input::make('unit.unit_safety_manager')->title(__('Данные руководителя ОТ'))
                        ->placeholder(__('ФИО руководителя по ОТ компании')),
                    Input::make('unit.unit_safety_manager_phone')
                        ->placeholder(__('Телефон руководителя по ОТ')),
                    Input::make('unit.unit_safety_manager_email')
                        ->placeholder(__('Почта руководителя по ОТ'))->type('email')
                ])
            ]),

        Layout::rows([
            Select::make('unit.status')->title('Статус')
                ->options([
                    'Активно' => 'Активно',
                    'Не активно'=> 'Не активно'
                ])
                ->empty('Не выбрано')
                ->help('Статус компании')
        ]),
        ];
    }
    public function createOrUpdate(Unit $unit, Request $request)
    {
        $unit->fill($request->get('unit'))->save();
        Alert::info('Данные о компании введены.');
        return redirect()->route('platform.unit.list');
    }
    public function remove(Unit $unit)
    {
        $unit->delete();
        Alert::info('Компания была удалена успешно.'); //TODO make info about sure deleting
        return redirect()->route('platform.unit.list');
    }
}
