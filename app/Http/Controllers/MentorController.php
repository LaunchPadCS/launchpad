<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantRating;
use App\Models\InterviewSlot;
use Auth;
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
        return view('mentor.applications');
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
            $data['id'] = $id;
            $slots = InterviewSlot::orderBy('start_time', 'asc')->get();
            return view('mentor.rate', compact('application', 'data', 'rating', 'slots'));
        } catch (\Exception $e) {
            return redirect('/')->with('message', 'Could not find application.');
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
            'applicants.name',
            'applicants.email',
            'applicants.interview_slot_id',
            \DB::raw('count(applicant_ratings.applicant_id) as ratings'),
            \DB::raw('TRUNCATE(AVG(applicant_ratings.rating),2) as avg'),
            \DB::raw('applicant_ratings.rating as myrating'),
            \DB::raw('interview_slot.start_time as starttime'),
        ])->leftJoin('applicant_ratings', 'applicant_ratings.applicant_id', '=', 'applicants.id')
        ->leftJoin('interview_slot', 'interview_slot.id', '=', 'applicants.interview_slot_id')
        ->groupBy('applicants.id');

        return Datatables::of($applications)->make(true);
    }
}
