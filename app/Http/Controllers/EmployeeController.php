<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show all data employee and relation with company
        $data = Employee::with('companies')->get();

        return response()->json([
            'data' => $data
        ]);
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
        // Data validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:10|max:13',
            'company_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ]);
        } else {

            // Create employee data
            Employee::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company_id' => $request->company_id
            ]);

            return response()->json([
                'message' => 'success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find employee data id base and relation with company
        $find = Employee::with('companies')->find($id);
        
        if($find){
            return response()->json([
                'data' => $find
            ]);

        } else {
            return response()->json([
                'message' => 'Not Found'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find employee data id base
        $find = Employee::find($id);

        if($find){
            // Data validation
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|min:10|max:13',
                'company_id' => 'required'
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()
                ]);
            } else {
    
                // Updating data
                $find->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'company_id' => $request->company_id
                ]);
    
                return response()->json([
                    'message' => 'success'
                ]);
            }
            
        } else {
            return response()->json([
                'message' => 'Not Found'
            ]);

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find employee data id base
        $find = Employee::find($id);
        
        if($find){
            // If data found, then remove it
            $find->delete();

            return response()->json([
                'message' => 'success'
            ]);
        } else {

            return response()->json([
                'message' => 'Not Found'
            ]);
        }
    }
}
