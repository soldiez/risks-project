<?php

namespace App\Orchid\Screens\Unit;

use App\Models\Unit;
use App\Orchid\Layouts\Unit\UnitListLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class UnitListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = "Список предприятий";
    public $description = 'Просмотр списка предприятий';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'units' => Unit::filters()->paginate(10)
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
                ->route('platform.unit.edit'),
            Button::make('Export file')
                ->method('exportUnit')
                ->icon('cloud-download')
                ->rawClick()
                ->novalidate()
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
            UnitListLayout::class
        ];
    }

    public function exportUnit()
    {
        $units = Unit::all([
            'id',
            'last_name',
            'first_name', //TODO make export units
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
            'Content-Disposition' => 'attachment; filename=units '.date('Y-m-d H-i-s').'.csv'
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
        $callback = function () use ($units, $columns) {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, $columns);

            foreach ($units as $unit) {
                fputcsv($stream, [
                    'id' => $unit->id,

                    'last_name' => $unit->last_name,
                    'first_name' => $unit->first_name,
                    'middle_name' => $unit->middle_name,
                    'phone' => $unit->phone,
                    'email' => $unit->email,
                    'personnel_number' => $unit->personnel_number,
                    'job_position' => $unit->job_position,
                    'department' => $unit->department,
                    'unit_id' => $unit->unit_id,
                    'birthday' => $unit->birthday,
                    'status' => $unit->status,
                    'created_at'=> $unit->created_at,
                    'updated_at' => $unit->updated_at
                ]);
            }
            fclose($stream);
        };
        return response()->stream($callback, 200, $headers);
    }



}
