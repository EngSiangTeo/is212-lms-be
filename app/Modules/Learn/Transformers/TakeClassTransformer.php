<?php

namespace App\Modules\Learn\Transformers;

use League\Fractal\TransformerAbstract;

class TakeClassTransformer extends TransformerAbstract
{
    public function transform($class)
    {
        $classArray = [
            'class_id' => $class->id,
            'course_id' => $class->course->id,
            'course_name' => $class->course->name,
            'course_description' => $class->course->description,
            'trainer_name' => $class->trainer->name,
            'trainer_email' => $class->trainer->email,
            'sections' => $class->section,
        ];

        return $classArray;
    }
}
