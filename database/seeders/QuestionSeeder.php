<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use App\Modules\Seeder\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileLocation = storage_path('app/data/questions.csv');
        $csv = Reader::createFromPath($fileLocation, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            $options = $record['options'];
            $options = explode("|", $options);
            Question::firstOrCreate([
                'questions'=>$record['questions'],
                'options'=>json_encode($options),
                'answer'=>$record['answer'],
                'quiz_id'=>$record['quiz_id']
            ]);
        }
    }
}
