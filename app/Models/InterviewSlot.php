<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Applicant;

class InterviewSlot extends Model
{
    protected $table = 'interview_slot';
    protected $fillable = ['*'];
    public $timestamps = false;
    protected $appends = ['formattedStartTime', 'formattedEndTime', 'applicationsCount', 'applicationsID'];

    public function getFormattedStartTimeAttribute()
    {
        $c = new \Carbon\Carbon($this->start_time);

        return $c->format('F j, g:i A');
    }

    public function getFormattedEndTimeAttribute()
    {
        $c = new \Carbon\Carbon($this->end_time);

        return $c->format('g:i A');
    }

    public function getApplicationsCountAttribute()
    {
        return Applicant::where('interview_slot_id',$this->id)->count();
    }

    public function assignments()
    {
        return $this->hasMany('App\Models\InterviewAssignment');
    }

    public function applicants()
    {
        return $this->hasMany('App\Models\Applicant');
    }

    public function getApplicationsIDAttribute()
    {
        $apps = Applicant::where('interview_slot_id',$this->id)->get(array('id'));
        $string = "/";
        foreach($apps as $app) {
            $string .= $app['id'] . "/";
        }
        return rtrim($string, '/');
    }
}