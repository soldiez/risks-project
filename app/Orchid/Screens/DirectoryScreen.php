<?php

namespace App\Orchid\Screens;

use App\Exports\Unit\UnitTerritoriesExport;
use App\Models\Unit;
use App\Models\Unit\UnitTerritory;
use App\Orchid\Layouts\Unit\UnitTerritoryListLayout;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DirectoryScreen extends Screen
{

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Справочники'; //TODO сделать справочники
    public $description = 'Перечень справочников';


//TODO  добавить записи про компании

    /**
     * Query data.
     *
     * @return array
     * @throws \Exception
     */
    public function query(): array
    {
//        $collection = Category::all();
//        $plucked = $collection->pluck('name','id');
       // dd($collection, $plucked);

        return [

          //  'workers' => Worker::paginate(10), //запрос данных из таблицы сотрудников
        //    'categories' => Category::filters()->paginate(10),
          //  'categoriesExp' => Category::all()->toArray(),
          //  'filteredCategories' => Category::where('id', '=', '14')->get(),
           // 'nestedCategories' => Category::nested()->get(),
         //   'jsonCategories' => Category::renderAsJson(),
            'territories' => UnitTerritory::where('status', 'active')->filters()->paginate(10),
           // 'input' => false
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

            DropDown::make('')
                ->icon('pencil')
                ->type(Color::DEFAULT())
                ->name(__('Создать элемент'))
                ->list([
                    ModalToggle::make('')
                        ->modal('createUnitTerritory')
                        ->method('createCategories', ['model' => 'unitTerritory'])
                        ->name(__('Территорию')),
                    ModalToggle::make('createUnitTerritory')
                        ->modal('createUnitTerritory')
                        ->method('createCategories', ['model' => 'unitTerritory'])
                        ->name(__('Подразделение')),
                    ModalToggle::make('createUnitTerritory')
                        ->modal('createUnitTerritory')
                        ->method('createCategories', ['model' => 'unitTerritory'])
                        ->name(__('Должность')),
                ]),



            DropDown::make('main')
            ->icon()
            ->type(Color::DEFAULT())
            ->name(__('Операции'))
            ->list([
                DropDown::make('second')
                    ->icon('cloud-download')
                    ->type(Color::DEFAULT())
                    ->name(__('Экспорт'))
                    ->list([
                        Button::make('export')
                            ->method('export')
                            ->name(__('Территории'))
                    ]),

                DropDown::make()
                    ->icon('cloud-upload')
                    ->type(Color::DEFAULT())
                    ->name(__('Импорт'))
                    ->list([
                        Button::make('export')
                            ->method('export')
                            ->name(__('Территории'))
                    ]),


            ])
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     * @throws \Exception
     */
    public function layout(): array
    {

        return [
            //TODO доделать модальное окно
            Layout::modal('asyncCategoryModal', [
                Layout::rows([
                    Input::make('id')->readonly()->hidden(),
                    Select::make('unit_id')->empty(__('Не выбрано'), 0)->fromModel(Unit::class, 'short_name', 'id')->title(__('Предприятие')),
                    Select::make('parent_id')->empty(__('Не выбрано'), 0)->fromQuery(UnitTerritory::where('status', 'active'), 'name')->title(__('Главная территория')),
                    Input::make('name')->required()->title(__('Территория')),
                ]) ])
                ->async('asyncGetCategory')
            ,
            Layout::modal('createUnitTerritory', [
                Layout::rows([
                 //   Input::make('id')->title(__('Добавление территорий'))->readonly()->hidden(),
                    Select::make('unit_id')->empty(__('Не выбрано'), 0)->fromModel(Unit::class, 'short_name', 'id')->title(__('Предприятие')),
                    Select::make('parent_id')->empty(__('Не выбрано'), 0)->fromQuery(UnitTerritory::where('status', 'active'), 'name')->title(__('Родительская территория')),
                    Matrix::make('categories')->columns([
                        __('Наименование') => 'name'])->title(__('Новые территории'))
                        ->fields(['name' => Input::make()->required()]),
                ])
            ])->title('Создание территорий')->applyButton(__('Сохранить')),


            Layout::tabs([

                __('Территории') =>

                    Layout::columns([
                        UnitTerritoryListLayout::class,
                        Layout::view('nested'),
                    ]),
                __('Подразделения') =>
                    Layout::view('nested'),

                __('Должности') =>

                    Layout::view('nested'),
            ]),
        ];
    }

    public function asyncGetCategory (Request $request)
    {
        return [
            'name' => $request->get('name'),
            'unit_id' => $request->get('unit_id'),
            'parent_id' => $request->get('parent_id'),
            'id' => $request->get('id'),
//            'input' => $request->json('input'),
//            'matrix' => $request->json('matrix'),
//            'model' => $request->json('model')

        ];
    }

    public function updateCategoryModal(Request $request)
    {
        $category = UnitTerritory::find($request->input('id'));
        $category->fill(['unit_id' => $request->input('unit_id', 0), 'parent_id' => $request->input('parent_id', 0),'name' => $request->input('name')])->save();
        Toast::info('Данные о территории обновлены');
    }

    // Delete one category
    public function removeCategory(Request $request) //TODO check to delete children?
    {
                $unitTerritories = UnitTerritory::descendantsAndSelf($request->input('id'));
                foreach ($unitTerritories as $unitTerritory) {
                    $unitTerritory->status = 'archive';
                    $unitTerritory->save();
                }
                Toast::info(__('Записи удалены'));
    }

    //Delete multiple choice in Box rows
    public function deleteChoiceRows(Request $request){
        $rows = $request->keys();
        foreach($rows as $row){
            if(is_int($row)){
                $unitTerritories = UnitTerritory::descendantsAndSelf($row);
                foreach ($unitTerritories as $unitTerritory){
                    $unitTerritory->status = 'archive';
                    $unitTerritory->save();
                }
            }
        }
    }

    public function createCategories(Request $request)
    {
        $categories = $request->categories;
        if ($categories) {
                    foreach ($categories as $category) {
                        UnitTerritory::create([
                            'unit_id' => $request->input('unit_id', 0),
                            'parent_id' => $request->input('parent_id', 0),
                            'name' => $category['name']]);
                    }
                    Toast::info('Данные о территориях введены');
        }
    }

    public function export(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(Unit::get(), 'unitTerritories.xlsx');
    }


}
