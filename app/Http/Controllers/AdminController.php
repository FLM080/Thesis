<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function exercise()
    {
        return view('admin.exercise');
    }
    public function workout()
    {
        return view('admin.workout');
    }
}
