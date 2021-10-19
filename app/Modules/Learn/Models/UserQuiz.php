<?php

namespace App\Modules\Learn\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
