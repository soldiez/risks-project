<?php

namespace App\Orchid\Layouts;

use App\Models\Category;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Listener;

class CategoryListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['firstBaba'];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncListenerMethod';

    /**
     * @return Layout[]
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function layouts(): array
    {

        return [
            \Orchid\Support\Facades\Layout::rows([
                Relation::make('firstBaba')
                    ->fromModel(Category::class, 'name')
                ->value('firstBaba'),

                    Input::make('secondBaba')

                        ->canSee($this->query->has('firstBaba')),

            ]),
        ];
    }
}
