<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'hours' => [
                        'required',
                    ],
            'minutes' => [
                        'required',
                    ],
        ]);

        Schedule::create($request->all());

        return redirect()->route('settings.index');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'hours' => [
                        'required',
                    ],
            'minutes' => [
                        'required',
                    ],
        ]);

        $schedule->update($request->all());

        return redirect()->route('settings.index');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('settings.index');
    }
}
