<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Mail\EmployeeCreated;
use App\Models\Employee;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:superAdmin|admin'], ['only' => ['index','show']]);
        $this->middleware(['permission:create-employee'], ['only' => ['create','store']]);
        $this->middleware(['permission:update-employee'], ['only' => ['edit','update']]);
        $this->middleware(['permission:delete-employee'], ['only' => ['destroy']]);
    }

    public function index()
    {
        $employees = Employee::with('user')->orderBy('created_at','desc')->get(); // Eager loading to minimize the number of queries
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'client')->get();
        $offices = Office::all();

        return view('employees.create', [
            'roles' => $roles,
            'offices' => $offices,
        ]);
    }



    public function store(StoreEmployeeRequest $request)
    {
        // Store the plain-text password temporarily
        $plainPassword = $request['password'];

        // Create the user with the encrypted password
        $user = User::create([
            'email' => $request['email'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'father_name' => $request['father_name'],
            'mother_name' => $request['mother_name'],
            'national_number' => $request['national_number'],
            'phone' => $request['phone'],
            'password' => bcrypt($request['password']),
        ]);

        $employee = Employee::create([
            'user_id' => $user->id,
            'office_id' => $request['office_id'],
            'join_date' => $request['join_date'],
            'salary' => $request['salary'],
        ]);

        $role = Role::find($request['role_id']);
        $user->assignRole($role);

        // Send the welcome email with the plain-text password
        Mail::to($user->email)->send(new EmployeeCreated($employee, $plainPassword));

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load('user', 'user.roles'); // Eager load related user and their roles
        return view('employees.show', compact('employee'));
    }


    public function edit(Employee $employee)
    {
        $roles = Role::all();
        $offices = Office::all();
        return view('employees.edit', compact('employee', 'roles','offices'));
    }


    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        // Update user details
        $employee->user->update($request->only(['email', 'first_name', 'last_name', 'father_name', 'mother_name', 'phone', 'national_number', 'password']));

        // Update employee details
        $employee->update($request->only(['office_id', 'join_date', 'salary']));

        // Handle role changes
        $newRole = Role::findById($request['role_id']);
        $employee->user->syncRoles($newRole);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $user = $employee->user; // Store reference to user
        $employee->delete(); // Delete the employee
        $user->delete(); // Delete the associated user if necessary

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

}
