<?php

namespace App\Orchid\Screens\Unit;

use App\Exports\Unit\UnitTerritoriesExport;
use App\Imports\UnitTerritoriesImport;
use App\Models\Unit;
use App\Models\Unit\UnitTerritory;
use App\Orchid\Actions\WorkerDeleteAll;
use App\Orchid\Filters\UnitTerritoryFilter;
use App\Orchid\Layouts\ActionButtonsRowsLayout;
use App\Orchid\Layouts\Unit\UnitTerritoryListLayout;
use App\Orchid\Layouts\UnitTerritoryListener;
use App\Orchid\Layouts\UnitTerritorySelection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UnitTerritoryListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список территорий';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {

        return [
            'territories' => UnitTerritory::where('status', 'active')->filtersApplySelection(UnitTerritorySelection::class)->filters()->paginate(10),
            //'json' => UnitTerritory::where('status', 'active')->get()->toTree()
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
            ModalToggle::make('')
                ->icon('pencil')
                ->type(Color::DEFAULT())
                ->modal('createCategory')
                ->method('createCategories')
                ->name(__('Создать элемент')),
            DropDown::make()
                ->icon('options-vertical')
                ->name(__('Действия'))
                ->type(Color::DEFAULT())
                ->list([
                    ModalToggle::make('import')
                        ->modal('uploadData')
                        ->icon('cloud-upload')
                        ->name(__('Импорт')),
                    Button::make('export')
                        ->icon('cloud-download')
                        // ->type(Color::DEFAULT())
                        ->method('storeExcel')
                        ->name(__('Экспорт'))
                    ->rawClick(),
                    Button::make('clear')
                        ->icon('trash')
                        //  ->type(Color::DEFAULT())
                        ->method('clear')
                        ->name(__('Очистить'))
                        ->confirm(__('Внимание - удалятся все элементы.'))
                ]),

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

            Layout::modal('asyncCategoryModal', [
                Layout::rows([
                    Input::make('id')->readonly()->hidden(),
                    Group::make([
                        Select::make('unit_id')->empty(__('Не выбрано'), 0)
                            ->fromModel(Unit::class, 'short_name', 'id')
                            ->title(__('Предприятие')),
                        Select::make('parent_id')->empty(__('Не выбрано'), 0)
                            ->fromQuery(UnitTerritory::where('status', 'active'), 'name')
                            ->title(__('Главная территория')),
                    ]),

                    Input::make('name')->required()->title(__('Территория')),
                ]) ])
                ->async('asyncGetCategory')
            ,
            Layout::modal('createCategory', [
                Layout::rows([
                    Group::make([
                        Select::make('unit_id')->empty(__('Не выбрано'), 0)
                            ->fromModel(Unit::class, 'short_name', 'id')
                            ->title(__('Предприятие')),
                        Select::make('parent_id')->empty(__('Не выбрано'), 0)
                            ->fromQuery(UnitTerritory::where('status', 'active'), 'name')
                            ->title(__('Родительская территория')),
                    ]),
                    Matrix::make('categories')->columns([
                        __('Наименование') => 'name'])->title(__('Новые территории'))
                        ->fields(['name' => Input::make()->required()]),
                ])
            ])->title('Создание территорий')->applyButton(__('Сохранить')),

            Layout::modal('uploadData', [
               Layout::rows([
                   Input::make('file')->type('file')->required()->help(__('Выберите файл для загрузки. Разрешены только файлы Excel')),
               //    Button::make('Upload')->type(Color::DEFAULT())->method('importExcel')->name(__('Загрузка'))
               ])
            ])->title(__('Загрузка данных'))->applyButton(__('Загрузить')),


                UnitTerritorySelection::class,
                UnitTerritoryListLayout::class,
        ];
    }

    public function asyncGetCategory (Request $request)
    {
        return [
            'name' => $request->get('name'),
            'unit_id' => $request->get('unit_id'),
            'parent_id' => $request->get('parent_id'),
            'id' => $request->get('id'),
        ];
    }

    public function updateCategoryModal(Request $request)
    {

        $category = UnitTerritory::find($request->input('id'));
        $category->fill([
            'unit_id' => $request->input('unit_id', 0),
            'parent_id' => $request->input('parent_id', 0),
            'name' => $request->input('name')])->save();
        Toast::info(__('Данные обновлены'));
    }

    //Delete multiple choice in Box rows
    public function deleteChoiceRows(Request $request){
        $rows = $request->keys();
        foreach($rows as $row){
            if(is_int($row)){
                $categories = UnitTerritory::descendantsAndSelf($row);
                foreach ($categories as $category){
                    $category->status = 'archive';
                    $category->save();
                }
            }
        }
        Toast::info(__('Записи удалены'));
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
            Toast::info(__('Данные введены'));
        }
    }

    public function storeExcel()
    {
         return Excel::download(new UnitTerritoriesExport, 'unitTerritories_'.now().'.xlsx');
    }

    public function importExcel() { //TODO import
         //   new UnitTerritoriesImport(), request()->file('nameFile'));
        return redirect('/')->with('success', 'All good!');;
    }

    public function clear () {
        $categories = UnitTerritory::where('status', 'active')->get();
        foreach ($categories as $category){ $category->status = 'archive'; $category->save(); }
         Toast::info(__('Записи удалены'));
    }

}
