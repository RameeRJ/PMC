<?php

namespace App\Http\Controllers;
use App\Models\Schedule;
use App\Models\Doctor;
use App\Models\Appointment;
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

public function getAppointment(Request $request)
{
    // Fetch all appointments with the related schedule and user data
    $appointments = Appointment::with(['schedule', 'user'])->get();

    return response()->json($appointments);
}

public function uploadPrescription(Request $request, $id)
{

    $request->validate([
        'prescription' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max size 2MB
    ]);
    // Find the appointment by ID
    $appointment = Appointment::findOrFail($id);

    // Ensure that the request contains a file
    if ($request->hasFile('prescription')) {
        $file = $request->file('prescription');

        // Get the original filename without hashing or modification
        $filename = $file->getClientOriginalName();

        // Store the file in the 'prescriptions' folder in the 'public' disk
        $path = $file->storeAs('prescriptions', $filename, 'public');

        // Save the path of the file in the 'prescription' column
        $appointment->prescription = $path;

        // Save the appointment with the updated prescription
        $appointment->save();

        // Return a success response
        return response()->json(['message' => 'Prescription uploaded successfully']);
    }

    // Return an error response if no file was uploaded
    return response()->json(['error' => 'No file uploaded'], 400);
}

public function getAppointmentsBySchedule($doctorId)
{
    $appointmentsBySchedule = Schedule::where('doctor_id', $doctorId)
        ->withCount('appointments')
        ->get();

    return response()->json($appointmentsBySchedule);
}



    
}
