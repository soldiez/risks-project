<?php

namespace App\Orchid\Screens\Risk;
use App\Models\Risk\RiskMethod;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;


class RiskMethodInfoScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Информация о методах оценки рисков';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'riskMethods' => RiskMethod::all()
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            ModalToggle::make('Создать новый метод')
                ->icon('note')
                ->modal('createRiskMethod')
                ->method('createRiskMethod')
                ->type(Color::DEFAULT()),
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
            Layout::modal('createRiskMethod', [
                Layout::rows([
                    Input::make('riskMethod.name')->title(__('Наименование метода'))->required(),
                    Input::make('riskMethod.category')->title(__('Категория метода')),
                    Input::make('riskMethod.status')->title(__('Статус метода'))
                        ->value(__('Не настроен'))->readonly()
                        ->help(__('Следует настроить метод в будущем')),
                    TextArea::make('riskMethod.info')
                        ->rows(4)
                        ->title(__('Информация о методе'))
                ]),
            ])->title(__('Создание нового метода')),

    Layout::table('riskMethods', [ //TODO style of table
        TD::make('name', __('Наименование')),
        TD::make('category', __('Категория')),
        TD::make('status', __('Статус')),
        TD::make('info', __('Информация')),
        TD::make('buttons', '')
            ->width('10px')
            ->render(function (RiskMethod $riskMethod){
                return Group::make([
                    Link::make(__('Редактирование'))
                    ->icon('note')
                    ->route('platform.riskEditMethod.edit', $riskMethod),
                    Button::make(__('Удаление'))
                        ->method('deleteRiskMethod', $riskMethod->attributesToArray())
                        ->icon('trash')
                        ->confirm(__('Подтвердите что хотите удалить запись? Удалятся и все настроенные параметры'))
                ]);
            })
    ]),

    ];
    }
    public function createRiskMethod (Request $request, RiskMethod $riskMethod){
        $riskMethod->fill($request->get('riskMethod'))->save();
    }

    public function deleteRiskMethod (RiskMethod $riskMethod){
        $riskMethod->delete();
        $riskMethod->riskSeverities()->delete();
        $riskMethod->riskProbabilities()->delete();
        $riskMethod->riskFrequencies()->delete();
        $riskMethod->riskZones()->delete();
        Alert::info('You have successfully deleted the method.');
        return redirect()->route('platform.riskMethod.info');
    }
    protected function textNotFound(): string
    {
        return __('Здесь еще нет записей');
    }
}
