<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Appointment;
use App\Http\Requests\AppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

public function getUserDetails()
{
    $user = Auth::user();

    // Return user details including profile picture
    return response()->json([
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'profile_pic' => $user->profile_picture // Add profile picture to response
    ]);
}

    public function updateProfile(Request $request)
{
    $user = Auth::user();
    
    // Validate the form data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email:rfc,dns|unique:users,email,' . $user->id,
        'phone' => 'required|string|regex:/^\d{10}$/',
        'profile_picture' => 'nullable|image|max:2048', // Ensure the profile picture is an image
    ]);

    // Update the user details
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    // Handle profile picture upload
    if ($request->hasFile('profilePicture')) {
        // Store the file in the public disk (storage/app/public)
        $filePath = $request->file('profilePicture')->store('profile_pictures', 'public');
        $user->profile_picture = $filePath;
    }

    $user->save(); // Save the user data

    return response()->json(['message' => 'Profile updated successfully', 'profile_pic' => $user->profile_picture]);
}

    public function getProfilePicture()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        
        if ($user) {
            // Construct the profile picture URL
            $profilePicUrl = $user->profile_picture 
                ? '/storage/profile_picture/' . $user->profile_picture 
                : '/images/avatar/default_avatar.jpeg';
            
            // Return the user data as a JSON response
            return response()->json([
                'profile_pic' => $profilePicUrl,
                'username' => $user->name,
                'email' => $user->email,
            ], 200);
        }
        
        // Return an error if the user is not found
        return response()->json(['error' => 'User not found'], 404);
    }

}