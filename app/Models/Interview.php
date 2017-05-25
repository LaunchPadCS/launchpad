<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
	protected $fillable = ['*'];
	protected $table = 'interview_notes';
	protected $appends = ['author'];
	public function getAuthorAttribute() {
		return User::where('id', $this->user_id)->first(['name'])['name'];
	}
}