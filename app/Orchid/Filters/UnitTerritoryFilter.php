<?php

namespace App\Orchid\Filters;

use App\Models\Unit\UnitTerritory;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;

class UnitTerritoryFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = ['parent_id', 'id'];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Родительская территория';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('parent_id', $this->request->get('parent_id'));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Select::make('parent_id')
                ->title('Территория')
                ->fromModel(
                    UnitTerritory::whereIn('id', UnitTerritory::where('status', 'active')->where('parent_id', '>', 0)->select('parent_id'))->orderBy('name'),
                    'name',
                    'id')
        ];
    }
    public function value(): string
    {
        return $this->name().': '.UnitTerritory::where('id', $this->request->get('parent_id'))->first()->name;
    }
}
