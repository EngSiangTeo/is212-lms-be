<?php

namespace App\Modules\Learn\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function class()
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }

    public function material()
    {
        return $this->hasMany(Material::class, 'section_id', 'id');
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class, 'section_id', 'id');
    }
}
