<?php

namespace App\Orchid\Layouts;

use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';



    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('parent_id', __('Категория'))->sort()->filter(TD::FILTER_TEXT)
            ->render(function ($target){
                if($target->parent_id > 0) {
                    $parentCategory = Category::find($target->parent_id);
                    return $parentCategory->name;
                    }
                return __('Главная категория');}
            ),

            TD::make('name',__('Элемент'))->sort()->filter(TD::FILTER_TEXT)->cantHide(),
            TD::make('info', __('Информация')),
            TD::make('editButton', '')
                ->cantHide()
                ->render(function ($target){
                    return
                        ModalToggle::make('')
                            ->modal('asyncCategoryModal')
                            ->icon('note')
                            ->modalTitle(__('Обновить данные'))
                            ->method('updateCategoryModal')
                            ->asyncParameters([
                                'category' => $target->id
                                ]);
                    })->width('20px')->align(TD::ALIGN_RIGHT),

            TD::make('deleteButton', '')
                ->cantHide()
                ->render(function ($target) {
                    return
                                Button::make(__(''))
                                    ->method('removeCategory')
                                    ->icon('trash')
                                    ->confirm(__('Подтвердите что хотите удалить запись'))
                                    ->parameters([
                                        'id' => $target->id,
                                    ]);
                            })
                ->width('10px')->align(TD::ALIGN_RIGHT),

        ];
    }
//    public function total():array
//    {
//        return [
//            TD::make('total')
//                ->align(TD::ALIGN_LEFT)
//                ->colspan(2)
//                ->render(function () {
//                    return Button::make('deleteChoice')
//                        ->method('deleteChoice')
//                        ->icon('trash')
//                        ->name(__('удалить выбранное'));
//                }),
//
//        ];
//    }
}
