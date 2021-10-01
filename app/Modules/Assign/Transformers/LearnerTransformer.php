<?php

namespace App\Modules\Assign\Transformers;

use League\Fractal\TransformerAbstract;

class LearnerTransformer extends TransformerAbstract
{
    public function transform($learner)
    {
        $learnerArray = [
            'id' => $learner->id,
            'name' => $learner->name,
            'email' => $learner->email
        ];

        return $learnerArray;
    }

}