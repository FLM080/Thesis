<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

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
        return view('users.profile');
    }

    //edit preferences
    public function setPreference(Request $request)
    {
        $formFields = $request->validate([
            
        ]);



        notify()->success('Preference updated successfully');
        return back();
    }
}
