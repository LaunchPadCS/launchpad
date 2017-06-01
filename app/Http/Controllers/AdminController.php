<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\InterviewAssignment;
use App\Models\InterviewPrompt;
use App\Models\InterviewSlot;
use App\Models\Question;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show manage users page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUsers()
    {
        $admins = Role::where('name', 'admin')->first();
        $mentors = Role::where('name', 'mentor')->first();
        $mentees = Role::where('name', 'mentee')->first();
        if ($admins != null) {
            $admins = $admins->users()->get();
        }
        if ($mentors != null) {
            $mentors = $mentors->users()->get();
        }
        if ($mentees != null) {
            $mentees = $mentees->users()->get();
        }

        return view('admin.users.all', ['admins' => $admins, 'mentors' => $mentors, 'mentees' => $mentees]);
    }

    public function editUser(User $user)
    {
        $raw_roles = [];
        $user_roles = $user->roles()->get(['name']);
        $roles = Role::all()->toArray();

        foreach ($user_roles as $r) {
            $raw_roles[] = $r->name;
        }
        foreach ($roles as $key => $role) {
            if (in_array($role['name'], $raw_roles)) {
                $roles[$key]['active'] = 1;
            } else {
                $roles[$key]['active'] = 0;
            }
        }

        return view('admin.users.edit', ['user' => $user, 'user_roles' => $user_roles, 'roles' => $roles]);
    }

    public function submitEditUser(Request $request, User $user)
    {
        $validator = \Validator::make($request->all(), [
            'name'    => 'required',
            'tagline' => 'required',
            'about'   => 'required',
            'email'   => \Illuminate\Validation\Rule::unique('users')->ignore($user->id),
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
        foreach ($request->roles as $role) {
            $user->roles()->attach($role);
        }

        return response()->json(['message' => 'success']);
    }

    public function disableAccount(User $user)
    {
        if ($user->id != Auth::user()->id) {
            $user->delete();

            return ['message' => 'success'];
        }
    }

    public function showApplicationForm()
    {
        $questions = Question::orderBy('order')->get();

        return view('admin.application_form.view', ['questions' => $questions]);
    }

    public function submitQuestionOrder(Request $request)
    {
        $arr = json_decode($request->getContent(), true);
        foreach ($arr as $key => $val) {
            $question = Question::where('id', $key)->first();
            $question->order = $val;
            $question->save();
        }

        return ['message' => 'success'];
    }

    public function createQuestion(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'text_create' => 'required',
            'type_create' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $order = Question::count();

        $question = new Question();
        $question->text = $request->text_create;
        $question->type = $request->type_create;
        $question->order = $order;
        $question->save();

        return ['message' => 'success', 'question' => ['id' => $question->id, 'type' => $question->type, 'order' => $question->order, 'text' => $question->text]];
    }

    public function updateQuestion(Request $request, Question $question)
    {
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

    public function deleteQuestion(Question $question)
    {
        $question->delete();

        return ['message' => 'success'];
    }

    public function submitTimeslot(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id'       => 'required|exists:applicants,id',
            'timeslot' => 'required|exists:interview_slot,id',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $applicant = Applicant::find($request->id);
        $applicant->interview_slot_id = $request->timeslot;
        $applicant->save();

        return response()->json(['message' => 'success']);
    }

    public function submitDecision()
    {
    }

    public function showCreateInterview()
    {
        return view('admin.interviews.create');
    }

    public function submitCreateInterview(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'start_time' => 'required|date_format:"d/m/Y H:i"',
            'end_time'   => 'required|date_format:"d/m/Y H:i"',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $start = new Carbon($request->start_time);
        $end = new Carbon($request->end_time);

        $interview = new InterviewSlot();
        $interview->start_time = $start;
        $interview->end_time = $end;
        $interview->save();

        return ['message' => 'success'];
    }

    public function submitBulkCreateInterview(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'start_day'  => 'required|date_format:"d/m/Y"',
            'end_day'    => 'required|date_format:"d/m/Y"',
            'start_time' => 'required|numeric',
            'end_time'   => 'required|numeric',
            'offset'     => 'required|numeric',
            'length'     => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $currDay = new Carbon($request->start_day);
        $endDay = new Carbon($request->end_day);

        while ($currDay <= $endDay) {
            $currTime = $currDay->copy();
            $currTime->addHours($request->start_time);

            $endTime = $currDay->copy();
            $endTime->addHours($request->end_time);

            while ($currTime <= $endTime) {
                $interview = new InterviewSlot();
                $interview->start_time = $currTime;
                $interview->end_time = $currTime->copy()->addMinutes($request->length);
                $interview->save();
                $currTime->addMinutes($request->length)->addMinutes($request->offset);
            }
            $currDay->addDays(1);
        }

        return response()->json(['message' => 'success']);
    }

    public function showAssignInterview()
    {
        $interviews = InterviewSlot::all();
        $mentors = Role::where('name', 'mentor')->first()->users()->get(['id', 'name']);
        $admins = Role::where('name', 'admin')->first()->users()->get(['id', 'name']);

        return view('admin.interviews.assign', ['interviews' => $interviews, 'interviewers' => $mentors->merge($admins)]);
    }

    public function submitAssignment(Request $request, InterviewSlot $interviewslot)
    {
        $interview_assignments = InterviewAssignment::where('interview_slot_id', $interviewslot->id)->delete();
        foreach ($request->mentors as $mentor) {
            $user = User::where('name', $mentor);
            if ($user->count()) {
                $user = $user->first();
                $assignment = new InterviewAssignment();
                $assignment->user_id = $user->id;
                $assignment->interview_slot_id = $interviewslot->id;
                $assignment->save();
            }
        }

        return ['message' => 'success'];
    }

    public function showManagePrompt()
    {
        return view('admin.interviews.prompt', ['prompt' => InterviewPrompt::first()]);
    }

    public function submitPrompt(Request $request)
    {
        $prompt = InterviewPrompt::first();
        $prompt->prompt = $request->data;
        $prompt->save();

        return response()->json(['message' => 'success', 'updated_at' => $prompt->updated_at->format('g:i:s A')]);
    }
}
