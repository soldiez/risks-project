<?php

namespace Database\Seeders;

use App\Models\InjuredBodyPart;
use Illuminate\Database\Seeder;

class InjuredBodyPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $injuredBodyParts = json_decode(file_get_contents(__DIR__ .'/files/injuredBodyParts.json'));
        foreach ($injuredBodyParts as $row){
            // $normalize = str_replace('+', )
            //  dd($row->name);
            InjuredBodyPart::create([
                'name' => $row->name
            ]);
        }
    }
}
