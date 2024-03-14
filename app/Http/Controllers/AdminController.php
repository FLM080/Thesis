<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.users');
    }

    public function workout()
    {
        return view('admin.workout');
    }
}
