<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    protected $table = 'responses';

    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }
}
