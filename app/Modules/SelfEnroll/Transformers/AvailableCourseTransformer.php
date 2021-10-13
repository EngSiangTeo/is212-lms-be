<?php

namespace App\Modules\SelfEnroll\Transformers;

use League\Fractal\TransformerAbstract;

class AvailableCourseTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['classes'];

    public function transform($course)
    {
        $courseArray = [
            'id' => $course->id,
            'name' => $course->name,
            'description' => $course->description,
            'enrollabled' => $course->enrollabled,
            'reason' => $course->reason ? $course->reason : '',
        ];

        return $courseArray;
    }

    public function includeClasses($course)
    {
        return $this->collection($course->classes, new CourseClassTransformer());
    }
}
