<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all employees with their associated users and departments
        $employees = Employee::whereHas('user', function ($query) {
            $query->where('status', 1);
        })->with('user', 'department')->get();

        // Loop through the employees and access user and department information
        foreach ($employees as $employee) {
            $user = $employee->user;
            $department = $employee->department;
        }
        return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'mobile_no' => 'required|numeric',
            'password' => 'required',
            'designation' => 'required',
            'department_id' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'dob' => 'required|date',
            'education' => 'required',
            'joining_date' => 'required|date'
        ]);
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'The email id already exists',
            ], 401);
        }
        $user_data = [
            'name' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];
        if($users = User::create($user_data))
        {
            $user_id = $users->id;

            $employee_data = [
                'user_id' => $user_id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'gender' => $request->gender,
                'mobile_no' => $request->mobile_no,
                'designation' => $request->designation,
                'department_id' => $request->department_id,
                'address' => $request->address,
                'dob' => $request->dob,
                'education' => $request->education,
                'joining_date' => $request->joining_date
            ];
            // return $employee_data;
            if($employees = Employee::create($employee_data))
            {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully Created one Employee',
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong',
                ]);
            }
            
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ], 401);
        }
        
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employees = Employee::with('user', 'department')->find($id);
        // foreach ($employees as $employee) {
            $user = $employees->user;
            $department = $employees->department;
        // }
        return response()->json($employees);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employees = Employee::with('user', 'department')->find($id);
        // foreach ($employees as $employee) {
            $user = $employees->user;
            $department = $employees->department;
        // }

        return response()->json($employees);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'mobile_no' => 'required|numeric',
            'designation' => 'required',
            'department_id' => 'required',
            'address' => 'required',
            'dob' => 'required|date',
            'education' => 'required',
            'joining_date' => 'required|date'
        ]);
        $employee_data = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'mobile_no' => $request->mobile_no,
            'designation' => $request->designation,
            'department_id' => $request->department_id,
            'address' => $request->address,
            'dob' => $request->dob,
            'education' => $request->education,
            'joining_date' => $request->joining_date
        ];
        $employee = Employee::find($id);
        
        if($employee->update($employee_data))
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Updates Employee',
            ]);
        }

        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee_data = [
            'status' => 0
        ];
        $employee = Employee::find($id);
        $user_id = $employee->user_id;

        $user = User::find($user_id);
        
        if($user->update($employee_data))
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Updates Employee',
            ]);
        }

        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ]);
        }
    }
}
