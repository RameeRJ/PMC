<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function Dstore(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'department' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^\d{10}$/',
        ]);

        // Create user with user_type set to 'doctor'
        $phoneWithCountryCode = '+91' . $request->phone;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $phoneWithCountryCode,
            'password' => Hash::make($request->password),
            'user_type' => 'doctor',
        ]);

        // Create the doctor record
        Doctor::create([
            'user_id' => $user->id, // Store the user_id in the doctors table
            'department' => $request->department,
        ]);

        return response()->json(['message' => 'Doctor added successfully'], 201);
    }

    public function index()
    {
        // Get all doctors with user details
        $doctors = Doctor::with('user')->get();
        return response()->json($doctors);
    }
}
