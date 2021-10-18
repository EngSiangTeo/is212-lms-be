<?php

namespace App\Modules\Learn\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
