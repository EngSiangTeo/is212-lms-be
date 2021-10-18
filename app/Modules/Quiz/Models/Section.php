<?php

namespace App\Modules\Quiz\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class, 'section_id', 'id');
    }
}
