<?php

namespace App\Http\Controllers;

use App\Models\BuildLibary;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $activeBuilds = BuildLibary::where('is_active', 1)->first();
        return view('home', [
            'builds' => BuildLibary::all(),
            'activeBuilds' => $activeBuilds
        ]);
    }
}
