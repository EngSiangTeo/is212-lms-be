<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Seeder\Models\Section;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('app/data/sections.csv');
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            Section::firstOrCreate([
                'name'=>$record['name'],
                'class_id'=>$record['class_id']
            ]);
        }
    }
}
