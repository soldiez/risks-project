<?php

namespace App\Exports\Unit;

use App\Models\Unit\UnitTerritory;
use Maatwebsite\Excel\Concerns\FromCollection;

class UnitTerritoriesExport implements FromCollection
{

    public function collection()
    {
        return UnitTerritory::all(); //TODO filters for file?
    }
}
