<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Seeder\Models\Material;

class CourseMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('app/data/course-materials.csv');
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            Material::firstOrCreate([
                'file_name'=>$record['file_name'],
                'type'=>$record['type'],
                'file_url'=>$record['file_url'],
                'section_id'=>$record['section_id']
            ]);
        }
    }
}
