<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();
        $events = $user->assignedEvents()->withCount('guests')->get();

        return view('client.dashboard', compact('events'));
    }
}