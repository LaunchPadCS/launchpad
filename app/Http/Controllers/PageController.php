<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PageController extends Controller {
    /**
     * Show the home page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('dashboard.home');
    }

    public function showSettings() {
        return view('dashboard.settings');
    }
    public function showSettingsPicture() {
        return view('dashboard.settings_picture');
    }
    public function submitSettings(Request $request) {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'tagline' => 'required',
            'about' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $user = Auth::user();
        $user->name = $request->name;
        $user->tagline = $request->tagline;
        $user->fb = $request->fb;
        $user->github = $request->github;
        $user->instagram = $request->instagram;
        $user->snapchat = $request->snapchat;
        $user->website = $request->website;
        $user->about = $request->about;
        if($request->enable_keyboard) {
            $user->enable_keyboard = 1;
        } else {
            $user->enable_keyboard = 0;
        }
        $user->save();
        return response()->json(['message' => 'success']);
    }
    public function tempProfilePicStore(Request $request) {
        try {
        $validator = \Validator::make($request->all(), [
            'photo' => 'required|image|max:10000',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $image = $request->file('photo');
        $destinationPath = storage_path('app/public') . '/uploads';
        $random = str_random(40);
        $name =  $random . '.' . $image->getClientOriginalExtension();
        if(!$image->move($destinationPath, $name)) {
            return $this->errors(['message' => 'Error saving the file.', 'code' => 400]);
        }
        Auth::user()->image = $name;
        Auth::user()->save();
        return response()->json(['message' => 'success', 'location' => asset('storage/uploads/' .  $name)], 200);
        } catch(\Exception $e) {
            echo "aw";
        }
    }
    public function cropPicture(Request $request) {
        $validator = \Validator::make($request->all(), [
            'width' => 'required',
            'height' => 'required',
            'x' => 'required',
            'y' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        
        $img = \Image::make(storage_path('app/public') . '/uploads/' . Auth::user()->image);
        $img->crop(intval($request->width), intval($request->height), intval($request->x), intval($request->y));
        $img->save(storage_path('app/public') . '/uploads/' . Auth::user()->image);

        \Session::flash('message', 'Updated profile photo!'); 
        return response()->json(['message' => 'success']);
    }   
}
