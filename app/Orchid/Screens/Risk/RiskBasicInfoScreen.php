<?php

namespace App\Orchid\Screens\Risk;

use App\Models\HazardCategory;
use App\Models\InjuredBodyPart;
use App\Models\RiskStatus;
use App\Orchid\Layouts\HazardCategoryLayout;
use App\Orchid\Layouts\InjuredBodyPartLayout;
use App\Orchid\Layouts\Risk\RiskStatusLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class RiskBasicInfoScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Информация о параметрах рисков';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'riskStatuses' => RiskStatus::filters()->defaultSort('name')->paginate(10),
            'hazardCategories' => HazardCategory::filters()->defaultSort('name')->paginate(10),
            'injuredBodyParts' => InjuredBodyPart::filters()->defaultSort('name')->paginate(10)
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        //Modal windows
        return [
            Layout::modal('createCategory', [
                Layout::rows([
                    Matrix::make('categories')
                        ->columns([
                            __('Наименование') => 'name'
                        ])
                ])
            ])->title(__('Создать категорию(и)')),

            Layout::modal('asyncUpdate', [
                Layout::rows([
                    Input::make('name')->title(__('Наименование'))
                ])
            ])->async('asyncGetData'),

//Tables with categories
            Layout::tabs([
                __('Статусы рисков') =>
                    Layout::columns([
                        RiskStatusLayout::class,
                        Layout::rows([
                            ModalToggle::make('')
                                ->modal('createCategory')
                                ->name(__('Создать статус риска'))
                                ->modalTitle(__('Создать статусы риска'))
                                ->icon('pencil')
                                ->type(Color::DEFAULT())
                                ->method('createCategory', ['model' => 'riskStatus']),
                        ])
                    ]),
                __('Категории опасности') =>
                    Layout::columns([
                        HazardCategoryLayout::class,
                        Layout::rows([
                            ModalToggle::make('')
                                ->modal('createCategory')
                                ->name(__('Создать категорию опасности'))
                                ->modalTitle(__('Создать категории опасностей'))
                                ->icon('pencil')
                                ->type(Color::DEFAULT())
                                ->method('createCategory', ['model' => 'hazardCategory']),
                        ]),
                    ]),
                __('Части тела') =>
                    Layout::columns([
                        InjuredBodyPartLayout::class,
                        Layout::rows([
                            ModalToggle::make('')
                                ->modal('createCategory')
                                ->name(__('Создать часть тела'))
                                ->modalTitle(__('Создать части тела'))
                                ->icon('pencil')
                                ->type(Color::DEFAULT())
                                ->method('createCategory', ['model' => 'injuredBodyPart']),
                        ]),
                    ]),
            ]),
        ];
    }

//Create category
    public function createCategory(Request $request)
    {
        $categories = $request->get('categories');
        $model = $request->query('model');
        if ($categories) {
            switch ($model) {
                case 'riskStatus':
                    foreach ($categories as $category) {
                        RiskStatus::create($category);
                    }
                    break;
                case 'hazardCategory':
                    foreach ($categories as $category) {
                        HazardCategory::create($category);
                    }
                    break;
                case 'injuredBodyPart':
                    foreach ($categories as $category) {
                        InjuredBodyPart::create($category);
                    }
            }
        }
    }

    public function asyncUpdate(Request $request)
    {
        $id = $request->query('id');
        $model = $request->query('model');
        if ($model == 'riskStatus') {
            RiskStatus::find($id)->fill(['name' => $request->input('name')])->save();
        }
        if ($model === 'hazardCategory') {
            HazardCategory::find($id)->fill(['name' => $request->input('name')])->save();
        }
        if ($model === 'injuredBodyPart') {
            InjuredBodyPart::find($id)->fill(['name' => $request->input('name')])->save();
        }
    }

    public function deleteRow(Request $request)
    {
        $id = $request->query('id');
        $model = $request->query('model');
        if ($model === 'riskStatus') {
            RiskStatus::find($id)->delete();
        }
        if ($model === 'hazardCategory') {
            HazardCategory::find($id)->delete();
        }
        if ($model === 'injuredBodyPart') {
            InjuredBodyPart::find($id)->delete();
        }
    }

    public function asyncGetData(Request $request)
    {
        return ['name' => $request->get('name')];
    }
}
