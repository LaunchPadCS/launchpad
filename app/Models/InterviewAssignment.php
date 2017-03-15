<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InterviewAssignment extends Model {
	protected $fillable = ['*'];
	protected $table="interview_assignment";

	public function post() {
        return $this->belongsTo('App\Models\InterviewSlot');
    }

	public function user() {
		return $this->belongsTo('App\Models\User');
	}
}