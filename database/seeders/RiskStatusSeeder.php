<?php

namespace Database\Seeders;

use App\Models\RiskStatus;
use Illuminate\Database\Seeder;

class RiskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $riskStatuses = [
            'Новый',
            'Проверен',
            'Актуален',
            'К пересмотру',
            'Пересмотрен',
            'Просрочен пересмотр',
            'Отменен',
            'Архивный',
        ];

        foreach ($riskStatuses as $riskStatus){
            RiskStatus::create([
               'name' => $riskStatus
            ]);
        }
    }
}
