<?php

namespace App\Modules\SelfEnroll\Transformers;

use League\Fractal\TransformerAbstract;

class CourseClassTransformer extends TransformerAbstract
{
    public function transform($class)
    {
        $trainerName = "";

        if ($class->trainer) {
            $trainerName = $class->trainer->name;
        }
        $classArray = [
            'id' => $class->id,
            'trainer_id' => $class->trainer_id,
            'start_time' => $class->start_time,
            'end_time' => $class->end_time,
            'start_date' => $class->start_date,
            'end_date' => $class->end_date,
            'trainer_name' => $trainerName,
        ];

        return $classArray;
    }
}
