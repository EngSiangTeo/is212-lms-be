<?php

namespace Database\Seeders;

use Carbon\Carbon;
use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Seeder\Models\UserCourseClass;

class UserCourseClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('app/data/user-course-classes.csv');
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            UserCourseClass::firstOrCreate([
                'user_id'=>$record['user_id'],
                'course_id'=>$record['course_id'],
                'class_id'=>$record['class_id'],
                'status'=>$record['status']
            ]);
        }
    }
}
