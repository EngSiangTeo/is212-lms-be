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
            'start_date' => $class->start_date,
            'end_date' => $class->end_date,
            'trainer_name' => $trainerName,
            'capacity' => $class->max_capacity,
            'enroll_start_date' => $class->enroll_start_date,
            'enroll_end_date' => $class->enroll_end_date,
            'current' => $class->enrolled->count()
        ];

        return $classArray;
    }
}
