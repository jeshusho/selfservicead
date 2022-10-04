<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Schedule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    
    public function index()
    {
        $notifications = Notification::select('id','name','days')->orderBy('days','DESC')->get();
        $schedules = Schedule::select('id','hours','minutes')->orderBy('hours','ASC')->orderBy('minutes','ASC')->get();
        $max_delay = Setting::where('parameter','max_delay')->first()->value;
        return Inertia::render('Settings', [
            'notifications' => $notifications,
            'schedules' => $schedules,
            'max_delay' => $max_delay,
        ]);
    }

}
