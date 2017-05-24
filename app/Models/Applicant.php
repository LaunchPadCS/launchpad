<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;
    protected $table = 'applicants';

    public function ratingInfo()
    {
        $count = ApplicantRating::where('applicant_id', $this->id)->get()->count();
        $sum = 0;
        $ratings = [];
        foreach ($this->ratings as $each) {
            $rating = intval($each->rating);
            $sum += $rating;
            $ratings[] = $rating;
        }
        $min = 0;
        $max = 0;
        $avg = 0;
        if ($count != 0) {
            $avg = $sum / $count;
            $min = min($ratings);
            $max = max($ratings);
            $avg = $sum / $count;
        }

        return
        [
            'count'=> $count,
            'min'  => $min,
            'max'  => $max,
            // "ratings"=>$ratings,
            'average'=> $avg,
        ];
    }

    protected $appends = ['reviews', 'UserRating', 'responses', 'name'];

    /**
     * Determine number of times the application has been reviewed.
     */
    public function getReviewsAttribute()
    {
        return ApplicantRating::where('applicant_id', $this->id)->get()->count();
    }

    public function getNameAttribute()
    {
        return $this->firstname . " " . $this->lastname;
    }
    public function getResponsesAttribute()
    {
        // Ideally use attributes and with()
        $r = FormResponse::where('application_id', $this->id)
            ->join('questions', 'responses.question_id', '=', 'questions.id')
            ->orderBy('questions.order', 'ASC')
            ->get();

        return $r;
        // return FormResponse::where('application_id', $this->id)->get();
    }

    public function getUserRatingAttribute()
    {
        $rating = ApplicantRating::where('applicant_id', $this->id)->where('user_id', Auth::user()->id)->first();
        if ($rating) {
            return $rating->rating;
        }

        return 'Not rated';
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\ApplicantRating');
    }

    public function interview_slot() {
        return $this->belongsTo('App\Models\InterviewSlot');
    }
}
