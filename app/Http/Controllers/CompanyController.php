<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all data Company
        $data = Company::all();

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
            'name' => 'required',
            'address' => 'required',
            'email' => 'required|email'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ]);
        } else {

            // Creating data
            Company::create([
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email
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
        // Finding data id base and relation with employee
        $find = Company::with('employees')->find($id);
        
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
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Finding data id base and relation with employee
        $find = Company::find($id);

        // Data validation
        if($find){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'email' => 'required|email'
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()
                ]);
            } else {
    
                // Updating data
                $find->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    'email' => $request->email
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
        // Finding data id base
        $find = Company::find($id);
        
        // Cek employee data relation with this company data
        $findRelation = Employee::where('company_id', $id);
        
        // If company data found
        if($find){

            // If find relation is true
            if($findRelation){
                // Delete data employee in relation with company
                $findRelation->delete();
                // Delete company
                $find->delete();

            } else {
                // If find relation is false, then just remove data company
                $find->delete();
                
            }

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
