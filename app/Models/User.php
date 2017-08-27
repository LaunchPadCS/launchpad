<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use SoftDeletes, EntrustUserTrait {
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['ratingCount', 'averageRatingValue'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function assignments()
    {
        return $this->hasMany('App\Models\InterviewAssignment');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\ApplicantRating');
    }

    public function getRatingCountAttribute()
    {
        return ApplicantRating::where('user_id', $this->id)->count();
    }

    public function getAverageRatingValueAttribute()
    {
        return ApplicantRating::where('user_id', $this->id)->avg('rating');
    }
}
