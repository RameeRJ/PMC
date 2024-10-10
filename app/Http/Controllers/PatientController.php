<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Appointment;
use App\Http\Requests\AppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
 
    public function appStore(AppointmentRequest $request)
{

    // Retrieve the authenticated user
    $user = Auth::user(); 
    // Get the schedule
    $schedule = Schedule::findOrFail($request->schedule_id);

    // Count the number of existing appointments for this schedule
    $appointmentCount = Appointment::where('schedule_id', $request->schedule_id)->count();

    // Check if the number of appointments exceeds or matches the maximum bookings allowed
    if ($appointmentCount >= $schedule->max_bookings) {
        return response()->json(['error' => 'No slots remaining. Maximum bookings reached.'], 400);
    }

    // Find the maximum token for the given schedule and increment it by 1
    $lastToken = Appointment::where('schedule_id', $request->schedule_id)
                            ->max('token');
    $nextToken = $lastToken !== null ? $lastToken + 1 : 1;

    // Create the appointment
    Appointment::create([
        'user_id' => $user->id,
        'schedule_id' => $request->schedule_id,
        'name' => $user->name,
        'age' => $request->age,
        'phone' => $request->phone,
        'place' => $request->place,
        'token' => $nextToken, // Incremented token value
    ]);

    return response()->json(['message' => 'Appointment created successfully'], 201);
}

public function getAppointmentsByUser()
{
    // Retrieve the authenticated user
    $user = Auth::user();

    // Fetch appointments for the user
    $appointments = Appointment::with(['schedule', 'schedule.doctor'])
                               ->where('user_id', $user->id)
                               ->get();

    // Return appointments with schedule details
    return response()->json($appointments, 200);
}

public function removeAppointment($id)
{
    try {
        $appointment = Appointment::findOrFail($id); // Find the appointment by ID

        $appointment->delete(); // Delete the appointment

        return response()->json(['message' => 'appointment removed successfully.'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'appointment not found or could not be deleted.'], 404);
    }
}

}