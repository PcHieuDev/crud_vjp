<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->query('search');
        $employees = Employee::where('name', 'LIKE', "%{$search}%")->get();
        return view('employees.index')->with('employees', $employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $fileName = time() . $request->file('photo')->getClientOriginalName();
        $path = $request->file('photo')->storeAs('images', $fileName, 'public');
        $requestData["photo"] = '/storage/' . $path;
        Employee::create($requestData);
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('employees.edit')->with('employee', $employee);

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // update the employee record
        $employee = Employee::find($id);
        $employee->name = $request->name;
        $employee->address = $request->address;
        $employee->mobile = $request->mobile;
        if ( $request->hasFile('photo')){
            // delete the old photo
            if (file::exists(public_path($employee->photo))){
                File::delete(public_path($employee->photo));
            }
            // upload the new photo
            $fileName = time() . $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('images', $fileName, 'public');
            $employee->photo = '/storage/' . $path;

        }
        $employee->save();
        // redirect to the employee list
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete the employee record
        $employee = Employee::find($id);
        if (file::exists(public_path($employee->photo))){
            File::delete(public_path($employee->photo));
        }
        $employee->delete();
        // redirect to the employee list
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');

        //
    }
    public function apiIndex()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }
}
