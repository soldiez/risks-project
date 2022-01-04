<?php

namespace Database\Seeders;

use App\Models\HazardCategory;
use Illuminate\Database\Seeder;

class HazardCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $hazardCategories = json_decode(file_get_contents(__DIR__ .'/files/hazardCategories.json'));
        foreach ($hazardCategories as $row){
           // $normalize = str_replace('+', )
          //  dd($row->name);
            HazardCategory::create([
               'name' => $row->name
            ]);
        }



    }
}
