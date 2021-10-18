<?php

namespace App\Modules\Learn\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Account\User\Models\User;

class UserCourseClass extends Model
{
    public function checkIfUserEnrollInClass($userId, $classId)
    {
        return $this->where(['user_id' => $userId,
                             'class_id' => $classId
                             ])
                    ->exists();
    }
}
