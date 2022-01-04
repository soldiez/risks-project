<?php

namespace App\Orchid\Screens\Worker;

use App\Models\Worker;
use App\Orchid\Layouts\Unit\WorkerListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class WorkerListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список сотрудников';
    public $description = 'Перечень сотрудников';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'workers' => Worker::filters()->paginate(10)
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
            Link::make('Создать новую запись')
            ->icon('pencil')
            ->route('platform.worker.edit'),
            Button::make('Export file')
                ->method('exportWorker')
                ->icon('cloud-download')
                ->rawClick()
                ->novalidate()
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     */
    public function layout(): array
    {
        return [

            WorkerListLayout::class
        ];
    }

    public function exportWorker()
    {
        $workers = Worker::all([
            'id',
            'last_name',
            'first_name',
            'middle_name',
            'phone',
            'email',
            'personnel_number',
            'job_position',
            'department',
            'unit_id',
            'birthday',
            'status',
            'created_at',
            'updated_at']);
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=workers '.date('Y-m-d H-i-s').'.csv'
        ];
        $columns = [
            'id',
            'last_name',
            'first_name',
            'middle_name',
            'phone',
            'email',
            'personnel_number',
            'job_position',
            'department',
            'unit_id',
            'birthday',
            'status',
            'created_at',
            'updated_at'
        ];
        $callback = function () use ($workers, $columns) {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, $columns);

            foreach ($workers as $worker) {
                fputcsv($stream, [
                    'id' => $worker->id,

                    'last_name' => $worker->last_name,
                    'first_name' => $worker->first_name,
                    'middle_name' => $worker->middle_name,
                    'phone' => $worker->phone,
                    'email' => $worker->email,
                    'personnel_number' => $worker->personnel_number,
                    'job_position' => $worker->job_position,
                    'department' => $worker->department,
                    'unit_id' => $worker->unit_id,
                    'birthday' => $worker->birthday,
                    'status' => $worker->status,
                    'created_at'=> $worker->created_at,
                    'updated_at' => $worker->updated_at
                ]);
            }
            fclose($stream);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function deleteChoiceRows(Request $request){
        $rows = $request->keys();
        foreach($rows as $row){
           Worker::where('last_name', $row)->delete();}
        }

}
