<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // show Register/Create Form
    public function create()
    {
        return view('users.register');
    }

    // show Login Form
    public function login()
    {
        return view('users.login');
    }
}
