<?php

namespace App\Modules\Assign\Transformers;

use League\Fractal\TransformerAbstract;

class EnrolledUserTransformer extends TransformerAbstract
{
    public function transform($user)
    {
        $userArray = [
            'id' => $user->user->id,
            'name' => $user->user->name,
            'status' => $user->status
        ];

        return $userArray;
    }
}
