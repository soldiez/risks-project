<?php

namespace App\Orchid\Layouts;

use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class CategoryRowsLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;


    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {

        return [

            Select::make('parent_id')
            ->fromQuery(Category::where('parent_id', '=', null), 'name')
            ->empty(__('Не выбрано'), '',),

            Group::make([
                Input::make('nameOne')->title('Category'),
                Input::make('infoOne')->title('Info'),
            ]),
            Group::make([Input::make('nameTwo'), Input::make('infoTwo')]),
            Group::make([Input::make('nameThree'), Input::make('infoThree')]),
            Group::make([Input::make('nameFour'), Input::make('infoFour')]),
            Group::make([Input::make('nameFive'), Input::make('infoFive')]),

            Button::make('Сохранить')
                ->icon('save')
                ->method('addCategories')
                ->type(Color::DEFAULT()),
        ];
    }


}
