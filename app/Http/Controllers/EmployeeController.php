<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('company')
        ->orderBy('id', 'desc')
        ->paginate(10);
        return EmployeeResource::collection($employees);

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
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable',
        ]);

        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save();

        // Employee::create($request->all());
        return response()->json([
            'message' => 'Employee created successfully.',
            'data' => new EmployeeResource($employee)

        ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable',
        ]);

        $employee = Employee::find($id);
        if(!$employee) {
            return response()->json([
                'message' => 'Employee not found.'
            ],400);
        }
        $employee->update($request->all());

        return response()->json([
            'message' => 'Employee updated successfully.',
            'data' => new EmployeeResource($employee)
        ],201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        if(!$employee) {
            return response()->json([
                'message' => 'Employee not found.'
            ],400);
        }
        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully.',
        ],201);
    }
}
