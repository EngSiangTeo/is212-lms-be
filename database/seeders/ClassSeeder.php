<?php

namespace Database\Seeders;

use Carbon\Carbon;
use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Seeder\Models\CourseClass;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('app/data/classes.csv');
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            if ($record['trainer_id'] == "null") {
                CourseClass::firstOrCreate([
                    'course_id'=>$record['course_id'],
                    'start_time'=>$record['start_time'],
                    'end_time'=>$record['end_time'],
                    'start_date'=>Carbon::createFromFormat('d/m/Y', $record['start_date'])->toDateString(),
                    'end_date'=>Carbon::createFromFormat('d/m/Y', $record['end_date'])->toDateString()
                ]);
            } else {
                CourseClass::firstOrCreate([
                    'course_id'=>$record['course_id'],
                    'trainer_id'=>$record['trainer_id'],
                    'start_time'=>$record['start_time'],
                    'end_time'=>$record['end_time'],
                    'start_date'=>Carbon::createFromFormat('d/m/Y', $record['start_date'])->toDateString(),
                    'end_date'=>Carbon::createFromFormat('d/m/Y', $record['end_date'])->toDateString()
                ]);
            }
        }
    }
}
