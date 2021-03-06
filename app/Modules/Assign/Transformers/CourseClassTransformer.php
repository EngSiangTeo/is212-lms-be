<?php

namespace App\Modules\Assign\Transformers;

use League\Fractal\TransformerAbstract;

class CourseClassTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['enrolled'];

    public function transform($class)
    {
        $classArray = [
            'class_id' => $class->id,
            'course_id' => $class->course->id,
            'course_name' => $class->course->name,
            'capacity' => $class->max_capacity,
            'current' => $class->enrolled->whereIn('status',['Enrolled','Completed'])->count()
        ];

        return $classArray;
    }

    public function includeEnrolled($class)
    {
        return $this->collection($class->enrolled, new EnrolledUserTransformer());
    }
}
