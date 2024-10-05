<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use App\Http\Requests\DoctorRequest;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function docStore(DoctorRequest $request)
    {
 
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

    public function docIndex()
    {
        $doctors = Doctor::with('user')->get();
        return response()->json($doctors);
    }

    public function docDestroy($id)
{
    // Find the doctor and associated user
    $doctor = Doctor::with('user')->findOrFail($id);
    $user = $doctor->user;

    // Soft delete the doctor
    $doctor->delete();

    // Soft delete the associated user
    $user->delete();

    return response()->json(['message' => 'Doctor and associated user soft deleted successfully']);
}

    public function editDoctor($id)
    {
            $doctor = Doctor::with('user')->findOrFail($id);
            return response()->json($doctor);
    }

        // Update method to update doctor's information
        public function updateDoctor(DoctorRequest $request, $id)
    {
            // Find the doctor and user
            $doctor = Doctor::findOrFail($id);
            $user = $doctor->user;

            // Update user details
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Update doctor details
            $doctor->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'department' => $request->department,
            ]);
            
            return response()->json(['message' => 'Doctor updated successfully']);
        }
        
        public function Depstore(DepartmentRequest $request)
        {
            $department = Department::create([
                'name' => $request->name,
            ]);
    
    
            return response()->json(['message' => 'Department added successfully'], 201);
        }

    public function Depindex()
    {
        return response()->json(Department::all());
    }

    // Store a new department

    // Delete a department
    public function Depdestroy($id)
    {
        $department = Department::find($id);
        
        if ($department) {
            $department->delete();
            return response()->json(['message' => 'Department deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }



}
