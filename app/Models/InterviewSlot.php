<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewSlot extends Model
{
    protected $table = 'interview_slot';
    protected $fillable = ['*'];
    public $timestamps = false;
    protected $appends = ['formattedDay', 'formattedStartTime', 'formattedEndTime', 'applicationsCount', 'applicationsID', 'pastDate'];

    public function getFormattedDayAttribute()
    {
        $c = new \Carbon\Carbon($this->start_time);

        return $c->format('F j');
    }

    public function getFormattedStartTimeAttribute()
    {
        $c = new \Carbon\Carbon($this->start_time);

        return $c->format('g:i A');
    }

    public function getFormattedEndTimeAttribute()
    {
        $c = new \Carbon\Carbon($this->end_time);

        return $c->format('g:i A');
    }

    public function getApplicationsCountAttribute()
    {
        return Applicant::where('interview_slot_id', $this->id)->count();
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
        $apps = Applicant::where('interview_slot_id', $this->id)->get(['id']);
        $string = '/';
        foreach ($apps as $app) {
            $string .= $app['id'].'/';
        }

        return rtrim($string, '/');
    }

    public function getPastDateAttribute()
    {
        if (\Carbon\Carbon::now() > $this->start_time) {
            return true;
        }

        return false;
    }
}
