<?php

namespace App\Http\Controllers;

use App\Mail\InterviewSlotSelected;
use App\Models\Applicant;
use App\Models\FormResponse;
use App\Models\InterviewSlot;
use App\Models\Question;
use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;

class PageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Role::where('name', 'admin')->first();
        $mentors = Role::where('name', 'mentor')->first();
        if ($admins != null) {
            $admins = $admins->users()->get();
        }
        if ($mentors != null) {
            $mentors = $mentors->users()->get();
        }

        return view('index', ['admins' => $admins, 'mentors' => $mentors]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (Auth::user()->hasRole(['admin', 'mentor'])) {
            $data = Auth::user()->with('assignments.slot.applicants')->first()->toArray();
            usort($data['assignments'], function ($a, $b) {
                return $a['slot']['start_time'] > $b['slot']['start_time'];
            });

            $ratings = User::with(['roles' => function ($q) {
                $q->where('name', 'mentor');
                $q->orWhere('name', 'admin');
            }])->get()->sortByDesc(function ($users) {
                return $users->ratingCount;
            });
        }

        return view('dashboard.home', ['data' => $data, 'ratings' => $ratings]);
    }

    public function showSettings()
    {
        return view('dashboard.settings');
    }

    public function showSettingsPicture()
    {
        return view('dashboard.settings_picture');
    }

    public function submitSettings(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'    => 'required',
            'tagline' => 'required',
            'about'   => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $user = Auth::user();
        $user->name = $request->name;
        $user->tagline = $request->tagline;
        $user->fb = $request->fb;
        $user->github = $request->github;
        $user->linkedin = $request->linkedin;
        $user->instagram = $request->instagram;
        $user->snapchat = $request->snapchat;
        $user->website = $request->website;
        $user->about = $request->about;
        if ($request->enable_keyboard) {
            $user->enable_keyboard = 1;
        } else {
            $user->enable_keyboard = 0;
        }
        $user->save();

        return response()->json(['message' => 'success']);
    }

    public function tempProfilePicStore(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'photo' => 'required|image|max:10000',
            ]);
            if ($validator->fails()) {
                return $validator->errors()->all();
            }
            $image = $request->file('photo');
            $destinationPath = storage_path('app/public').'/uploads';
            $random = str_random(40);
            $name = $random.'.'.$image->getClientOriginalExtension();
            if (!$image->move($destinationPath, $name)) {
                return $this->errors(['message' => 'Error saving the file.', 'code' => 400]);
            }
            Auth::user()->image = $name;
            Auth::user()->save();

            return response()->json(['message' => 'success', 'location' => asset('storage/uploads/'.$name)], 200);
        } catch (\Exception $e) {
            echo 'aw';
        }
    }

    public function cropPicture(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'width'  => 'required',
            'height' => 'required',
            'x'      => 'required',
            'y'      => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $userImage = explode('.', Auth::user()->image);
        $imgname = $userImage[0].'_p.'.$userImage[1];

        $img = \Image::make(storage_path('app/public').'/uploads/'.Auth::user()->image);
        $img->crop(intval($request->width), intval($request->height), intval($request->x), intval($request->y));
        $img->resize(300, 300);
        $img->save(storage_path('app/public').'/uploads/'.$imgname);

        $user = Auth::user();
        $user->image = $imgname;
        $user->save();

        \Session::flash('message', 'Updated profile photo!');

        return response()->json(['message' => 'success']);
    }

    public function showApplicationForm()
    {
        $questions = Question::orderBy('order')->get();

        return view('apply', ['questions' => $questions]);
    }

    public function submitApplicationForm(Request $request)
    {
        if (env('APPLICATIONS_OPEN') == false) {
            return;
        }

        $validator = \Validator::make($request->all(), [
            'firstname'  => 'required',
            'lastname'   => 'required',
            'email'      => 'required|email|unique:applicants,email',
        ]);
        $errors = [];
        $questions = Question::all();
        foreach ($questions as $question) {
            if (!$request->has($question->id)) {
                $errors[] = $question->id;
            }
        }
        if ($validator->fails() || !empty($errors)) {
            $validator_errors = $validator->errors()->keys();
            if (!empty($errors)) {
                $validator_errors[] = 'Please fill in all the application questions.';
            }

            return [$validator_errors, 'errors' => $errors];
        }

        $applicant = new Applicant();
        $applicant->firstname = $request->firstname;
        $applicant->lastname = $request->lastname;
        $applicant->email = $request->email;
        $applicant->save();

        foreach ($request->all() as $key => $value) {
            if ($key != '_token' && $key != 'firstname' && $key != 'email' && $key != 'lastname') {
                $response = new FormResponse();
                $response->application_id = $applicant->id;
                $response->question_id = $key;
                $response->response = $value;
                $response->save();
            }
        }

        return ['message' => 'success'];
    }

    public function showInterviewSelectionForm(Request $request)
    {
        if ($request->hashid == null) {
            return 'invalid';
        } else {
            $id = Hashids::decode($request->hashid);
            if (empty($id)) {
                return 'invalid';
            }
            $applicant = Applicant::find($id[0]);
            $interviewSlots = InterviewSlot::where('start_time', '>', \Carbon\Carbon::now())->get()->sortBy('start_time');
            $selectedSlot = InterviewSlot::where('id', $applicant->interview_slot_id)->first();

            return view('interview', ['applicant' => $applicant, 'slots' => $interviewSlots, 'selected' => $selectedSlot]);
        }
    }

    public function submitInterviewSelectionForm(Request $request)
    {
        if (empty($request->id) || empty($request->slot)) {
            return ['message' => 'error'];
        } else {
            $id = Hashids::decode($request->id);
            if (empty($id)) {
                return ['message' => 'error'];
            }
            $interview = InterviewSlot::where('id', $request->slot);
            if ($interview->count()) {
                $applicant = Applicant::find($id[0]);
                $applicant->interview_slot_id = $request->slot;
                $applicant->save();
                $interview = $interview->first();

                Mail::to($applicant->email)
                    ->queue(new InterviewSlotSelected($applicant, $interview));

                return ['message' => 'success', 'content' => 'Your selected interview slot is on '.$interview->formattedDay . ' from ' . $interview->formattedStartTime.' to '.$interview->formattedEndTime.' in '.$interview->location];
            }
        }
    }
}
