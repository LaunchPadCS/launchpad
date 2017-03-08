<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
