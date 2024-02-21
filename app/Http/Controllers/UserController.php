<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PreferenceController;

class UserController extends Controller
{
    // show Register/Create Form
    public function create()
    {
        return view('users.register');
    }

    //create new user
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:255','regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
        ]);

        //Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        //Create User
        $user = User::create($formFields);

        //Sign User In
        //auth()->login($user);

        //Redirect to logion page with success message'
        notify()->success(__('Account created successfully'));
        return redirect('/login');
    }

    // show Login Form
    public function login()
    {
        return view('users.login');
    }

    //authenticate user
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(auth()->attempt($credentials)){
            $request->session()->regenerate();
            notify()->success(__('Successfully logged in'));
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => __('The provided credentials do not match our records.'),
        ])->onlyInput();
    }

    //logout user
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        notify()->success(__('Successfully logged out'));
        return redirect('/');
    }

    //show user profile
    public function show()
    {
        $user = Auth::user(); 
        $gender = Users::where('id', $user->id)->first(); 

        $genderColumn = Users::getGenderColumn();
        $genders = Users::getColumnEnums($genderColumn);
        $selectedGender = $user->gender;

        $preferenceController = new PreferenceController();
        $preferenceData = $preferenceController->show();

        $columns = $preferenceData['columns'];
        $options = $preferenceData['options'];
        $selected = $preferenceData['selected'];

        return view('users.profile', compact('genderColumn', 'genders', 'selectedGender', 'columns', 'options', 'selected'));
    }

    //update gender
    public function updateGender(Request $request)
    {
        $user = Auth::user();
        $users = users::where('id', $user->id)->first();
        if (!$users) {
            $users = new users();
            $users->user_id = $user->id;
        }
        $users->gender = $request->gender;
        $users->save();
        return redirect('/profile');
    }
}