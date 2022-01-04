<?php

namespace App\Imports;

use App\Models\Unit\UnitTerritory;
use Maatwebsite\Excel\Concerns\ToModel;

class UnitTerritoriesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new UnitTerritory([
            //
            'name'=> $row[0] //TODO mapping columns

        ]);
    }
}
