<?php

namespace App\Orchid\Actions;

use Illuminate\Support\Collection;
use Orchid\Crud\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;

class WorkerDeleteAll extends Action
{
    /**
     * The button of the action.
     *
     * @return Button
     */
    public function button(): Button
    {
        return Button::make('Delete')->icon('fire');
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Illuminate\Support\Collection $models
     */
    public function handle(Collection $models)
    {
        $models->each(function ($item) {
            // action
            $item->delete();
        });

        Toast::message('It worked!');
    }
}
