<?php

namespace App\Modules\Learn\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function question()
    {
        return $this->hasMany(Question::class, 'quiz_id', 'id');
    }
}
