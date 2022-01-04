<?php

namespace App\Orchid\Screens\Risk;

use App\Models\Risk\RiskFrequency;
use App\Models\Risk\RiskMethod;
use App\Models\Risk\RiskProbability;
use App\Models\Risk\RiskSeverity;
use App\Models\Risk\RiskZone;
use App\Orchid\Layouts\Risk\CreateRiskFrequencyLayout;
use App\Orchid\Layouts\Risk\CreateRiskProbabilityLayout;
use App\Orchid\Layouts\Risk\CreateRiskSeverityLayout;
use App\Orchid\Layouts\Risk\CreateRiskZoneLayout;
use App\Orchid\Layouts\Risk\EditRiskFrequencyLayout;
use App\Orchid\Layouts\Risk\EditRiskProbabilityLayout;
use App\Orchid\Layouts\Risk\EditRiskSeverityLayout;
use App\Orchid\Layouts\Risk\EditRiskZoneLayout;
use App\Orchid\Layouts\Risk\RiskFrequencyLayout;
use App\Orchid\Layouts\Risk\RiskProbabilityLayout;
use App\Orchid\Layouts\Risk\RiskSeverityLayout;
use App\Orchid\Layouts\Risk\RiskZoneLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;


class RiskEditMethodScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Настройка метода риска';


    /**
     * Query data.
     *
     * @param RiskMethod $riskMethod
     * @return array
     */
    public function query(RiskMethod $riskMethod): array
    {
       // $riskMethodId = $riskMethod->getAttributeValue('id');

        return [
            'riskMethod' => $riskMethod,
            'riskSeverities' => $riskMethod->riskSeverities()->get(),
            'riskProbabilities' => $riskMethod->riskProbabilities()->get(),
            'riskFrequencies' => $riskMethod->riskFrequencies()->get(),
            'riskZones' => $riskMethod->riskZones()->get()
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
            //Modal windows for Risk Severity
            Layout::modal('asyncEditRiskSeverity', [ EditRiskSeverityLayout::class
            ])->async('asyncGetRiskSeverity')->title(__('Редактирование вида тяжести')),
            Layout::modal('createRiskSeverity', [ CreateRiskSeverityLayout::class
            ])->title(__('Создание вида тяжести')),

            //Modal windows for Risk Probability
            Layout::modal('asyncEditRiskProbability', [ EditRiskProbabilityLayout::class
            ])->async('asyncGetRiskProbability')->title(__('Редактирование вида вероятности')),
            Layout::modal('createRiskProbability', [ CreateRiskProbabilityLayout::class
            ])->title(__('Создание вида вероятности')),

            //Modal windows for Risk Frequency
            Layout::modal('asyncEditRiskFrequency', [ EditRiskFrequencyLayout::class
            ])->async('asyncGetRiskFrequency')->title(__('Редактирование вида частоты')),
            Layout::modal('createRiskFrequency', [ CreateRiskFrequencyLayout::class
            ])->title(__('Создание вида частоты')),

            //Modal windows for Risk Zones
            Layout::modal('asyncEditRiskZone', [ EditRiskZoneLayout::class
            ])->async('asyncGetRiskZone')->title(__('Редактирование зон матрицы')),
            Layout::modal('createRiskZone', [ CreateRiskZoneLayout::class
            ])->title(__('Создание зон матрицы')),


            //Параметры метода
            Layout::block([
                Layout::rows([
                    Button::make('Обновить метод')
                        ->icon('note')
                        ->method('createOrUpdate')
                        ->type(Color::DEFAULT()),
                  //  Input::make('riskMethod.id'),
                    Group::make([
                        Input::make('riskMethod.name')->title(__('Наименование метода'))->required(),
                        Input::make('riskMethod.category')->title(__('Категория метода')),
                    ]),
                    Group::make([
                        Input::make('riskMethod.status')->title(__('Статус метода')),
                        TextArea::make('riskMethod.info')
                            ->rows(4)
                            ->title(__('Информация о методе')),//TODO make statuses
                                                    //TODO logic and additional params of method
                                                    //TODO choice using of frequencies, number or symbol matrix, review period
                        //TODO make choice active method
                    ]),
                    Group::make([
                        Switcher::make('free-switch') //TODO switcher
                            ->sendTrueOrFalse()
                            ->title('Free switch')
                            ->placeholder('Event for free')
                            ->help('Event for free'),
                    ])
                    ])
            ])->title(__('Параметры метода'))
            ->description(__('Описание параметров метода и что-то еще')),

//Параметры тяжести
            Layout::block([
                Layout::rows([
                    ModalToggle::make('createRiskSeverity')
                        ->modal('createRiskSeverity')
                        ->icon('pencil')
                        ->method('createRiskSeverity')
                        ->name(__('Создать вид тяжести'))
                        ->type(Color::DEFAULT()),
                ]),
                RiskSeverityLayout::class,
            ])->title(__('Виды тяжести'))
            ->description(__('Что такое тяжесть и прочее'))
            ,
            //Параметры вероятности
            Layout::block([
                Layout::rows([
                    ModalToggle::make('createRiskProbability')
                        ->modal('createRiskProbability')
                        ->icon('pencil')
                        ->method('createRiskProbability')
                        ->name(__('Создать вид вероятности'))
                        ->type(Color::DEFAULT()),
                ]),
                RiskProbabilityLayout::class,
            ])->title(__('Виды вероятности'))
                ->description(__('Что такое вероятность и прочее'))
            ,
            //Параметры частоты
            Layout::block([
                Layout::rows([
                    ModalToggle::make('createRiskFrequency')
                        ->modal('createRiskFrequency')
                        ->icon('pencil')
                        ->method('createRiskFrequency')
                        ->name(__('Создать вид частоты'))
                        ->type(Color::DEFAULT()),
                ]),
                RiskFrequencyLayout::class,
            ])->title(__('Виды частоты'))
                ->description(__('Что такое частота и прочее'))
            ,
            //Параметры зон риска
            Layout::block([
                Layout::rows([
                    ModalToggle::make('createRiskZone')
                        ->modal('createRiskZone')
                        ->icon('pencil')
                        ->method('createRiskZone')
                        ->name(__('Создать зону марицы'))
                        ->type(Color::DEFAULT()),
                ]),
                RiskZoneLayout::class,
            ])->title(__('Настройка зон матрицы'))
                ->description(__('Что такое матрица и прочее'))
        ];
    }

    public function createRiskSeverity(Request $request, RiskSeverity $riskSeverity){
    $riskSeverity->fill(['risk_method_id' => $request->input('riskMethod.id'),
        'name' => $request->input('riskSeverity.name'), 'value' => $request->input('riskSeverity.value'),
    'info' => $request->input('riskSeverity.info')
    ])->save();
    }
    public function createRiskProbability(Request $request, RiskProbability $riskProbability){
        $riskProbability->fill(['risk_method_id' => $request->input('riskMethod.id'),
            'name' => $request->input('riskProbability.name'), 'value' => $request->input('riskProbability.value'),
            'info' => $request->input('riskProbability.info')
        ])->save();
    }
    public function createRiskFrequency (Request $request, RiskFrequency $riskFrequency){
        $riskFrequency->fill(['risk_method_id' => $request->input('riskMethod.id'),
            'name' => $request->input('riskFrequency.name'), 'value' => $request->input('riskFrequency.value'),
            'info' => $request->input('riskFrequency.info')
        ])->save();
    }
    public function createRiskZone (Request $request, RiskZone $riskZone){
        $riskZone->fill(['risk_method_id' => $request->input('riskMethod.id'),
            'value' => $request->input('riskZone.value'), 'colour' => $request->input('riskZone.colour'),
            'manage' => $request->input('riskZone.manage'), 'info' => $request->input('riskZone.info')
        ])->save();
    }

    public function asyncEditRiskSeverity (Request $request) {
       $riskSeverity = RiskSeverity::find($request->get('id'));
        $riskSeverity->risk_method_id = $request->input('riskSeverity.risk_method_id');
        $riskSeverity->name = $request->input('riskSeverity.name');
        $riskSeverity->value = $request->input('riskSeverity.value');
        $riskSeverity->info = $request->input('riskSeverity.info');
        $riskSeverity->save();
    }
    public function asyncEditRiskProbability (Request $request) {
        $riskProbability = RiskProbability::find($request->get('id'));
        $riskProbability->risk_method_id = $request->input('riskProbability.risk_method_id');
        $riskProbability->name = $request->input('riskProbability.name');
        $riskProbability->value = $request->input('riskProbability.value');
        $riskProbability->info = $request->input('riskProbability.info');
        $riskProbability->save();
    }
    public function asyncEditRiskFrequency (Request $request) {
        $riskFrequency = RiskFrequency::find($request->get('id'));
        $riskFrequency->risk_method_id = $request->input('riskFrequency.risk_method_id');
        $riskFrequency->name = $request->input('riskFrequency.name');
        $riskFrequency->value = $request->input('riskFrequency.value');
        $riskFrequency->info = $request->input('riskFrequency.info');
        $riskFrequency->save();
    }
    public function asyncEditRiskZone (Request $request) {
        $riskZone = RiskZone::find($request->get('id'));
        $riskZone->risk_method_id = $request->input('riskZone.risk_method_id');
        $riskZone->value = $request->input('riskZone.value');
        $riskZone->colour = $request->input('riskZone.colour');
        $riskZone->manage = $request->input('riskZone.manage');
        $riskZone->info = $request->input('riskZone.info');
        $riskZone->save();
    }

    public function createOrUpdate(RiskMethod $riskMethod, Request $request)
    {
        $riskMethod->fill($request->get('riskMethod'))->save(); //TODO other models
        Alert::info('Данные о методе введены.');
        return redirect()->route('platform.riskMethod.info');
    }

    public function removeRiskSeverity (RiskSeverity $riskSeverity) { $riskSeverity->delete(); }
    public function removeRiskProbability (RiskProbability $riskProbability) { $riskProbability->delete(); }
    public function removeRiskFrequency (RiskFrequency $riskFrequency) { $riskFrequency->delete(); }
    public function removeRiskZone (RiskZone $riskZone) { $riskZone->delete(); }

    public function asyncGetRiskSeverity (RiskSeverity $riskSeverity){ return ['riskSeverity' => $riskSeverity];}
    public function asyncGetRiskProbability (RiskProbability $riskProbability){ return ['riskProbability' => $riskProbability];}
    public function asyncGetRiskFrequency (RiskFrequency $riskFrequency){ return ['riskFrequency' => $riskFrequency];}
    public function asyncGetRiskZone (RiskZone $riskZone){ return ['riskZone' => $riskZone];}
}
