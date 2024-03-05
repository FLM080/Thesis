<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Preference;
use App\Services\DatabaseSchemaService;
use Intervention\Image\ImageManagerStatic as Image;



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
            'name' => ['required', 'min:3', 'max:30','regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6', 'max:64', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
        ]);

        //Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);


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

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        notify()->success(__('Successfully logged out'));
        return redirect('/');
    }

    public function show()
    {
        $user = Auth::user(); 
        $gender = User::where('id', $user->id)->first(); 

        $genderColumn = 'user_gender';
        $genders = DatabaseSchemaService::getColumnEnums('users', $genderColumn);
        $selectedGender = $user->user_gender;


        $preference = new Preference();
        $preferenceData = $preference->getUserPreference($user);

        $columns = $preferenceData['columns'];
        $options = $preferenceData['options'];
        $selected = $preferenceData['selected'];

        return view('users.profile', compact('genderColumn', 'genders', 'selectedGender', 'columns', 'options', 'selected'));
    }

    public function updateGender(Request $request)
    {
        $user = Auth::user();
        $users = user::where('id', $user->id)->first();
        if (!$users) {
            $users = new user();
            $users->user_id = $user->id;
        }
        $users->user_gender = $request->user_gender;
        $users->save();

        if ($users->save()) {
            notify()->success(__('Successfully saved gender'));
        } else {
            notify()->error(__('Failed to save gender'));
        }
        return redirect('/profile');
    }

    public function updateDetails(Request $request)
    {
        $user = Auth::user();
        $users = User::where('id', $user->id)->first();
        if (!$users) {
            $users = new User();
            $users->user_id = $user->id;
        }
    
        if ($request->has('name') && !empty($request->name)) {
            $formFields = $request->validate([
                'name' => ['nullable', 'min:3', 'max:30', 'regex:/^[a-zA-Z\s]+$/'],
            ]);
            $users->name = $formFields['name'];
        }
    
    if ($request->hasFile('image')) {
        $extensions = config('images.profile.extension');
        $request->validate([
            'image' => 'required|image|mimes:' . implode(',', $extensions) . '',
        ]);

        $image = $request->file('image');
        $name = $user->id . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images/profile');

        $existingFiles = glob($destinationPath . '/' . $user->id . '.*');
        foreach ($existingFiles as $existingFile) {
            if ($existingFile !== $destinationPath . '/' . $name) {
                unlink($existingFile);
            }
        }

        $resizedImage = Image::make($image)->resize(320, 320, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $resizedImage->save($destinationPath . '/' . $name);
        $user->profile_picture = $destinationPath . '/' . $name;
        $imageUploaded = true;
    }
        $users->save();
    
        if ($users->wasChanged() || $imageUploaded) {
            notify()->success(__('Successfully saved details'));
        } else {
            notify()->error(__('Failed to save details'));
        }
        return redirect('/profile');
    }


    public function updateCredentials(Request $request)
    {
        $user = Auth::user();
        $user = User::find(Auth::id());

        $formFields = $request->validate([
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'min:6', 'max:64', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
        ]);

        if (!empty($formFields['password']) || !empty($formFields['email'])) {
            if (!empty($formFields['password'])) {
                $formFields['password'] = bcrypt($formFields['password']);
                $user->password = $formFields['password'];
            }
            if (!empty($formFields['email'])) {
                $user->email = $formFields['email'];
            }
            $user->save();
        }

        if ($user->wasChanged()) {
            notify()->success(__('Successfully updated credentials'));
        } else {
            notify()->error(__('Failed to update credentials'));
        }

        return redirect('/profile');
    }
}