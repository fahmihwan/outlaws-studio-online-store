<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        // dd(Auth::guard('webadmin')->user());
        return view('cms.pages.dashboard.index');
    }
}
