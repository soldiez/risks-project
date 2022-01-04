<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class WorkerFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = ['first_name'];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Имя';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('first_name', 'like', '%'.$this->request->get('first_name').'%');
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        //
        return [
        Input::make('first_name')
            ->type('text')
            ->value($this->request->get('first_name'))
            ->placeholder('Search...')
            ->title('Search')
            ];
    }
}
