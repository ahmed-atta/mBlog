<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function edit()
    {
        return view("profile.edit");
    }
    public function update(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'userid' => 'required|integer',
            'gender' => 'required|in:male,female',
        ]);

        if ($validator->fails()) {
            return redirect('profile/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $gender = $request->input('gender');
        $userid = $request->input('userid');
        $user = User::findOrFail($userid);
        
        if($user) {
            $user->gender = $gender;
            $user->save();
            return redirect('home');
        } else {
            return redirect('logout');
        }
    }

}
