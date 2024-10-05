<?php

namespace App\Http\Controllers;
use App\Models\Schedule;
use App\Models\Doctor;
use App\Http\Requests\ScheduleRequest;

use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function getSchedules($doctorId)
    {
        $schedules = Schedule::where('doctor_id', $doctorId)->get(); // Fetch schedules based on doctor_id
        return response()->json(['schedules' => $schedules]);
    }

    

    public function Schedulestore(ScheduleRequest $request)
    {
        \Log::info('Request Data:', $request->all());


        $schedule = Schedule::create([
            'doctor_id'     => $request->doctor_id,
            'schedule_title' => $request->schedule_title,
            'schedule_date'  => $request->schedule_date,
            'start_time'  => $request->start_time,
            'end_time'  => $request->end_time,
            'max_bookings'  => $request->max_bookings,
  

        ]);
        return response()->json([
            'message' => 'Schedule created successfully!',
            'schedule' => $schedule
        ], 201);
    }

    public function getDoctorIdByEmail(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find the doctor by email
        $doctor = Doctor::where('email', $request->email)->first();

        // Check if doctor exists
        if ($doctor) {
            // Return the doctor ID
            return response()->json(['doctor_id' => $doctor->id], 200);
        }

        // If not found, return a 404 response
        return response()->json(['message' => 'Doctor not found'], 404);
    }

    
    public function removeSchedule($id)
{
    try {
        $schedule = Schedule::findOrFail($id); // Find the schedule by ID

        $schedule->delete(); // Delete the schedule

        return response()->json(['message' => 'Schedule removed successfully.'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Schedule not found or could not be deleted.'], 404);
    }
}


    
}
