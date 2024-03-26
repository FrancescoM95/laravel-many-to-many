<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function __invoke()
    {
        $projects = Project::all();
        return view('guest.home', compact('projects'));
    }
}
