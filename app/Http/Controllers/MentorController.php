<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantRating;
use App\Models\Interview;
use App\Models\InterviewPrompt;
use App\Models\InterviewSlot;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Datatables;
use DB;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    /**
     * Show all applications.
     *
     * @return \Illuminate\Http\Response
     */
    public function showApplications()
    {
        $accepted = Applicant::where('decision', 1)->orWhere('decision', 2)->count();
        $denied = Applicant::where('decision', 0)->count();

        return view('mentor.applications', ['accepted' => $accepted, 'denied' => $denied]);
    }

    public function showInterviewSchedule()
    {
        $interviews = InterviewSlot::orderBy('start_time', 'asc')->get();
        $mentors = User::get(['id', 'name'])->toArray();

        return view('mentor.schedule', ['interviews' => $interviews, 'mentors' => $mentors]);
    }

    public function getNextApplicationID()
    {
        $user = Auth::user();
        foreach (Applicant::orderBy(DB::raw('RAND()'))->get() as $app) {
            $rating = ApplicantRating::where('applicant_id', $app->id)->where('user_id', '=', $user->id)->first();
            if (!$rating) {
                return $app->id;
            }
        }
    }

    public function showRate($id = null)
    {
        if (is_null($id)) {
            $id = $this->getNextApplicationID();
            // If user has rated all applicants
            if (is_null($id)) {
                return redirect()->action('PageController@dashboard')->with('message', 'Looks like you\'ve rated everyone. Great job!');
            }

            return redirect()->action('MentorController@showRate', ['id' => $id]);
        }

        try {
            $application = Applicant::findOrFail($id);
            $rating = ApplicantRating::where('applicant_id', $id)->where('user_id', Auth::user()->id)->first();
            if ($rating) {
                $rating = $rating->toArray();
            }
            $slots = InterviewSlot::orderBy('start_time', 'asc')->get();
            $interviews = Interview::where('applicant_id', $id)->get();

            return view('mentor.rate', compact('application', 'rating', 'slots', 'interviews'));
        } catch (\Exception $e) {
            return redirect()->action('MentorController@showApplications')->with('message', 'Could not find application.');
        }
    }

    public function submitRating(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'app_id' => 'required|exists:applicants,id',
            'rating' => 'required|numeric|max:3|min:1',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $rating = ApplicantRating::firstOrNew(['applicant_id' => $request->app_id, 'user_id' => Auth::user()->id]);
        $rating->applicant_id = $request->app_id;
        $rating->user_id = Auth::user()->id;
        $rating->rating = $request->rating;
        $rating->save();

        return response()->json(['message' => 'success', 'redirect' => action('MentorController@showRate', ['id' => $this->getNextApplicationID()])]);
    }

    public function getApplications()
    {
        $applications = Applicant::select([
            'applicants.id',
            'applicants.firstname',
            'applicants.lastname',
            'applicants.email',
            'applicants.interview_slot_id',
            \DB::raw('count(applicant_ratings.applicant_id) as ratings'),
            \DB::raw('TRUNCATE(AVG(applicant_ratings.rating),2) as avg'),
            \DB::raw('applicant_ratings.rating as myrating'),
            \DB::raw('interview_slot.start_time as starttime'),
            \DB::raw('TRUNCATE(AVG(interview_notes.rating),2) as interview_avg'),
            \DB::raw('TRUNCATE((AVG(interview_notes.rating)+AVG(applicant_ratings.rating))/2, 3) as total_avg'),
        ])->leftJoin('applicant_ratings', 'applicant_ratings.applicant_id', '=', 'applicants.id')
        ->leftJoin('interview_slot', 'interview_slot.id', '=', 'applicants.interview_slot_id')
        ->leftJoin('interview_notes', 'interview_notes.applicant_id', '=', 'applicants.id')
        ->groupBy('applicants.id');

        return Datatables::of($applications)->make(true);
    }

    public function showInterview($id = null)
    {
        if ($id) {
            $params = array_unique(explode('/', $id));
            $prompt = InterviewPrompt::first();

            try {
                $applicants = [];
                $interviews = [];
                foreach ($params as $interviewID) {
                    $applicant = Applicant::findOrFail($interviewID, ['id', 'firstname', 'lastname', 'email'])->toArray();
                    $applicants[] = $applicant;
                    $interview = Interview::where('applicant_id', $interviewID)->where('user_id', Auth::user()->id)->first();
                    if (!is_null($interview)) {
                        $interviews[] = $interview->toArray();
                    } else {
                        $interviews[] = ['notes' => '', 'applicant_id' => $applicant['id'], 'user_id' => Auth::user()->id, 'rating' => 0];
                    }
                }

                return view('mentor.interview', ['prompt' => $prompt, 'applicants' => $applicants, 'interviews' => $interviews]);
            } catch (\Exception $e) {
                return redirect()->action('PageController@dashboard')->with('message', 'Error building interview');
            }
        }

        return redirect()->action('PageController@dashboard')->with('message', 'Error building interview');
    }

    public function updateInterview(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'applicant_id' => 'required|exists:applicants,id',
            'notes'        => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $interview = Interview::firstOrNew(['applicant_id' => $request->applicant_id, 'user_id' => Auth::user()->id]);
        $interview->applicant_id = $request->applicant_id;
        $interview->user_id = Auth::user()->id;
        $interview->notes = $request->notes;
        $interview->save();
        $updated_at = new Carbon($interview->updated_at);

        return response()->json(['message' => 'success', 'updated_at' => $updated_at->format('g:i:s A')]);
    }

    public function updateInterviewRating(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'applicant_id' => 'required|exists:applicants,id',
            'rating'       => 'required|between:1,5',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $interview = Interview::firstOrNew(['applicant_id' => $request->applicant_id, 'user_id' => Auth::user()->id]);
        $interview->applicant_id = $request->applicant_id;
        $interview->user_id = Auth::user()->id;
        $interview->rating = $request->rating;
        $interview->save();
        $updated_at = new Carbon($interview->updated_at);

        return response()->json(['message' => 'success']);
    }
}
