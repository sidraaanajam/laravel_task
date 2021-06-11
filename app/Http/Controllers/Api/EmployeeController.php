<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){

        $employee = Employee::with('company')->get()->toJson(JSON_PRETTY_PRINT);

        return response($employee, 200);
    }
    public function show($id) {
        if (Employee::where('id', $id)->exists()) {
            $employee = Employee::with('company')->where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($employee, 200);
        } else {
            return response()->json([
                "message" => "Employee not found"
            ], 404);
        }
    }

    public function store(Request $request)
    {
        if(is_null($request->first_name)) {

            return response()->json([
                "message" => "First Name is required"
            ], 400);
        }
        if(is_null($request->last_name)) {

            return response()->json([
                "message" => "Last Name is required"
            ], 400);
        }

        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save();

        return response()->json([
            "message" => "Employee record created"
        ], 201);
    }

    public function update(Request $request, $id) {

        if (Employee::where('id', $id)->exists()) {

            $employee = Employee::find($id);
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company_id = $request->company_id;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Employee not found"
            ], 404);
        }
    }

    public function delete ($id) {

        if(Employee::where('id', $id)->exists()) {
            $employee = Employee::find($id);
            $employee->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Employee not found"
            ], 404);
        }
    }
}
