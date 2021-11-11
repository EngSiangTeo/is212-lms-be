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
                    'start_date'=>Carbon::createFromFormat('d/m/Y H:i:s', $record['start_date'])->toDateTimeString(),
                    'end_date'=>Carbon::createFromFormat('d/m/Y H:i:s', $record['end_date'])->toDateTimeString(),
                    'enroll_start_date'=>Carbon::createFromFormat('d/m/Y H:i:s', $record['enroll_start_date'])->toDateTimeString(),
                    'enroll_end_date'=>Carbon::createFromFormat('d/m/Y H:i:s', $record['enroll_end_date'])->toDateTimeString(),
                    'max_capacity'=>$record['max_capacity']
                ]);
            } else {
                CourseClass::firstOrCreate([
                    'course_id'=>$record['course_id'],
                    'trainer_id'=>$record['trainer_id'],
                    'start_date'=>Carbon::createFromFormat('d/m/Y H:i:s', $record['start_date'])->toDateTimeString(),
                    'end_date'=>Carbon::createFromFormat('d/m/Y H:i:s', $record['end_date'])->toDateTimeString(),
                    'enroll_start_date'=>Carbon::createFromFormat('d/m/Y H:i:s', $record['enroll_start_date'])->toDateTimeString(),
                    'enroll_end_date'=>Carbon::createFromFormat('d/m/Y H:i:s', $record['enroll_end_date'])->toDateTimeString(),
                    'max_capacity'=>$record['max_capacity']
                ]);
            }
        }
    }
}
