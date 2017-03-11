<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Question;

class AdminController extends Controller {
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard() {
        return view('admin.home');
    }

    /**
     * Show manage users page
     *
     * @return \Illuminate\Http\Response
     */
    public function showUsers() {
		$admins = Role::where("name", "admin")->first();
		$mentors = Role::where("name", "mentor")->first();
		$mentees = Role::where("name", "mentee")->first();
		if($admins != null) {
			$admins = $admins->users()->get();
		}
		if($mentors != null) {
			$mentors = $mentors->users()->get();
		}
		if($mentees != null) {
			$mentees = $mentees->users()->get();
		}
        return view('admin.users.all', ['admins' => $admins, 'mentors' => $mentors, 'mentees' => $mentees]);
    }

    public function editUser(User $user) {
    	$raw_roles = [];
    	$user_roles = $user->roles()->get(['name']);
    	$roles = Role::all()->toArray();

    	foreach($user_roles as $r) {
    		$raw_roles[] = $r->name;
    	}
    	foreach($roles as $key => $role) {
    		if(in_array($role['name'], $raw_roles)) {
    			$roles[$key]['active'] = 1;
    		} else {
    			$roles[$key]['active'] = 0;
    		}
    	}

    	return view('admin.users.edit', ['user' => $user, 'user_roles' => $user_roles, 'roles' => $roles]);
    }

    public function submitEditUser(Request $request, User $user) {
    	$validator = \Validator::make($request->all(), [
            'name' => 'required',
            'tagline' => 'required',
            'about' => 'required',
            'email' => \Illuminate\Validation\Rule::unique('users')->ignore($user->id)
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $user->name = $request->name;
        $user->tagline = $request->tagline;
        $user->fb = $request->fb;
        $user->github = $request->github;
        $user->instagram = $request->instagram;
        $user->snapchat = $request->snapchat;
        $user->website = $request->website;
        $user->about = $request->about;
        $user->save();
        RoleUser::where('user_id', $user->id)->delete();
        foreach($request->roles as $role) {
        	$user->roles()->attach($role);
        }
        return response()->json(['message' => 'success']);
    }

    public function disableAccount(User $user) {
        if($user->id != Auth::user()->id) {
    	   $user->delete();
           return ['message' => 'success'];
        }
    }

    public function showApplicationForm() {
        $questions = Question::orderBy('order')->get();
        return view('admin.application_form.view', ['questions' => $questions]);
    }

    public function submitQuestionOrder(Request $request) {
        $arr = json_decode($request->getContent(),true);
        foreach($arr as $key => $val) {
            $question = Question::where('id', $key)->first();
            $question->order = $val;
            $question->save();
        }
        return ['message' => 'success'];
    }

    public function updateQuestion(Request $request, Question $question) {
        $validator = \Validator::make($request->all(), [
            'text' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $question->text = $request->text;  
        $question->type = $request->type;  
        $question->save();
        return ['message' => 'success'];
    }

    public function deleteQuestion(Question $question) {
        $question->delete();
        return ['message' => 'success'];
    }
}
