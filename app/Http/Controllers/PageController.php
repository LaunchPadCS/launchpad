<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\FormResponse;
use App\Models\Question;
use App\Models\User;
use App\Models\Role;
use Auth;
use Illuminate\Http\Request;

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
        if(Auth::user()->hasRole(['admin', 'mentor'])) {
            $data = User::where('id', Auth::user()->id)->with('assignments.slot')->first();
        }
        return view('dashboard.home', ['data' => $data]);
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

        $img = \Image::make(storage_path('app/public').'/uploads/'.Auth::user()->image);
        $img->crop(intval($request->width), intval($request->height), intval($request->x), intval($request->y));
        $img->save(storage_path('app/public').'/uploads/'.Auth::user()->image);

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
        $validator = \Validator::make($request->all(), [
            'firstname'  => 'required',
            'lastname'  => 'required',
            'email' => 'required|email|unique:applicants,email',
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
}
