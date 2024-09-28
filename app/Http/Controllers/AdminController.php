<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Doctor;
use App\Http\Requests\DoctorRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function docstore(DoctorRequest $request)
    {
        // Validate the reques

        // Create user with user_type set to 'doctor'


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'user_type' => 'doctor',
        ]);

        // Create the doctor record
        Doctor::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
        ]);

        return response()->json(['message' => 'Doctor added successfully'], 201);
    }

    public function docindex()
    {
        $doctors = Doctor::with('user')->get();
        return response()->json($doctors);
    }
}
