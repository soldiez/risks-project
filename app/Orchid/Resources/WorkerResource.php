<?php

namespace App\Orchid\Resources;

use App\Orchid\Actions\WorkerDeleteAll;
use App\Orchid\Filters\WorkerFilter;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Filters\WithTrashed;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class WorkerResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Worker::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [


                Group::make([
                    Input::make('worker.last_name')->title('Фамилия')->placeholder('Фамилия сотрудника')
                        ->help('Введите фамилию сотрудника')->required(),
                    Input::make('worker.first_name')->title('Имя')->placeholder('Имя сотрудника')
                        ->help('Введите имя сотрудника')->required(),
                    Input::make('worker.middle_name')->title('Отчество')->placeholder('Отчество сотрудника')
                        ->help('Введите отчество сотрудника')->required(),
                ]),

                Group::make([
                    Input::make('worker.phone')->title('Телефон')->placeholder('Телефон сотрудника')
                        ->help('Введите телефон сотрудника')->mask('(999) 999-9999'),
                    Input::make('worker.email')->title('Электронная почта')->placeholder('Электронная почта')
                        ->help('Введите электронную почту сотрудника')->type('email'),
                    Input::make('worker.personnel_number')->title('Табельный номер')->placeholder('Табельный номер')
                        ->help('Введите табельный номер сотрудника')->type('number'),
                    DateTimer::make('worker.birthday')->title('День рождения сотрудника')->placeholder('Дата')
                        ->help('Введите день рождения')->allowInput()->format('Y-m-d'),
                ]),
                Group::make([
                    Input::make('worker.job_position')->title('Должность')->placeholder('должность сотрудника')
                        ->help('Введите должность сотрудника'),
                    Input::make('worker.department')->title('Подразделение')->placeholder('Подразделение')
                        ->help('Введите подразделение сотрудника'),
                    Input::make('worker.unit_id')->title('Компания')->placeholder('Компания')
                        ->help('Введите компанию сотрудника'),
                    Select::make('worker.status')->title('Статус')
                        ->options([
                            'Активен' => 'Активен',
                            'Не активен'=> 'Не активен'
                        ])
                        ->empty('Не выбрано')
                        ->help('Статус сотрудника в компании'),
                ]),




        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('first_name', 'Имя')->sort()->filter(TD::FILTER_TEXT),
            TD::make('middle_name', 'Отчество')->filter(TD::FILTER_TEXT),
            TD::make('personnel_number', 'Табельный номер'),
            TD::make('job_position', 'Должность')->sort()->filter(TD::FILTER_TEXT),
            TD::make('department', 'Подразделение')->sort()->filter(TD::FILTER_TEXT),
            TD::make('unit_id', 'Компания')->sort()->filter(TD::FILTER_TEXT),
            TD::make('phone', 'Телефон')->filter(TD::FILTER_TEXT),
            TD::make('email', 'Почта')->filter(TD::FILTER_TEXT),
            TD::make('birthday', 'Дата рождения')->sort()->filter(TD::FILTER_TEXT),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('first_name'),
            Sight::make('middle_name'),
            Sight::make('personnel_number'),
            Sight::make('job_position'),
            Sight::make('department'),
            Sight::make('unit_id'),

        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            new WorkerFilter()

        ];
    }
    /**
     * Get the text for the list breadcrumbs.
     *
     * @return string
     */
    public static function listBreadcrumbsMessage(): string
    {
        return static::label();
    }

    /**
     * Get the text for the create breadcrumbs.
     *
     * @return string
     */
    public static function createBreadcrumbsMessage(): string
    {
        return __('New :resource', ['resource' => static::singularLabel()]);
    }

    /**
     * Get the text for the edit breadcrumbs.
     *
     * @return string
     */
    public static function editBreadcrumbsMessage(): string
    {
        return __('Edit :resource', ['resource' => static::singularLabel()]);
    }

    public function actions(): array
    {
        return [
            WorkerDeleteAll::class,
        ];
    }


}
