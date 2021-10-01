<?php

namespace App\Modules\Assign\Transformers;

use League\Fractal\TransformerAbstract;

class CourseTransformer extends TransformerAbstract
{
    public function transform($course)
    {
        $courseArray = [
            'id' => $course->id,
            'name' => $course->name
        ];

        return $courseArray;
    }

}