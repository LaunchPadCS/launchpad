<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewAssignment extends Model
{
    protected $fillable = ['*'];
    protected $table = 'interview_assignment';
    public $timestamps = false;

    public function slot()
    {
        return $this->belongsTo('App\Models\InterviewSlot', 'interview_slot_id', 'id')->orderBy('start_time');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
