<?php

namespace App\Orchid\Screens\Worker;

use App\Models\Category;
use App\Models\Unit;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class WorkerEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Редактирование сотрудника';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Редактирование данных о сотруднике';
    /**
     * @var bool
     */
    public $exists = false;


    /**
     * Query data.
     *
     * @param Worker $worker
     * @return array
     */
    public function query(Worker $worker): array
    {
        $this->exists = $worker->exists;

        if ($this->exists) {
            $this->name = 'Редактирование данных о сотруднике';
        }
        return [
            'worker' => $worker
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
            Button::make('Создать сотрудника')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
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
            Layout::columns([
                Layout::rows([
                    Input::make('worker.last_name')->title('Фамилия')->horizontal()->required(),
                    Input::make('worker.first_name')->title('Имя')->horizontal()->required(),
                    Input::make('worker.middle_name')->title('Отчество')->horizontal(),
                    Input::make('worker.phone')->title('Телефон')
                        ->mask('(999) 999-9999')->horizontal(),
                    Input::make('worker.email')->title('Электронная почта')
                        ->type('email')->horizontal(),
                    DateTimer::make('worker.birthday')->title('День рождения')
                        ->allowInput()->format('Y-m-d')->horizontal()
                ]),
                Layout::rows([
                    Select::make('worker.unit_id')->title('Компания')
                        ->fromModel(Unit::class, 'short_name', 'id')->horizontal(),
                    Input::make('worker.department')->title('Подразделение')->horizontal(),
                    Input::make('worker.job_position')->title('Должность')->horizontal(),
                    Input::make('worker.personnel_number')->title('Табельный номер')
                        ->type('number')->horizontal(),
                    Select::make('worker.status')->title('Статус')
                        ->options([
                            'active' => 'Активен',
                            'archive' => 'Не активен'
                        ])->empty('Не выбрано')->horizontal(),
                ]),
            ]),
        ];
    }

    public function createOrUpdate(Worker $worker, Request $request)
    {
        //  dd($request);

        $worker->fill($request->get('worker'))->save();
        Alert::info('Данные о сотруднике введены.');
        return redirect()->route('platform.worker.list');
    }

    public function remove(Worker $worker)
    {
        $worker->delete();
        Alert::info('You have successfully deleted the post.');
        return redirect()->route('platform.worker.list');
    }
}
