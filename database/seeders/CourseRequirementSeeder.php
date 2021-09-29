<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Seeder\Models\CourseRequirement;

class CourseRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('app/data/course-requirements.csv');
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            CourseRequirement::firstOrCreate([
                'course_id'=>$record['course_id'],
                'require_course_id'=>$record['require_course_id']
            ]);
        }
    }
}
