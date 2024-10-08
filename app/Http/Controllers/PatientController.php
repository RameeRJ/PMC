<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Method to fetch all schedules along with the doctor name
    public function getSchedules()
    {
        // Fetch all schedules with the associated doctor
        $schedules = Schedule::with('doctor:id,name')->get();

        // Return the schedules as JSON
        return response()->json(['schedules' => $schedules]);
    }
}
