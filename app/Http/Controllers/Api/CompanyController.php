<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index() {
        $companies = Company::get()->toJson(JSON_PRETTY_PRINT);
        return response($companies, 200);
    }

    public function show($id) {
        if (Company::where('id', $id)->exists()) {
            $company = Company::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($company, 200);
        } else {
            return response()->json([
                "message" => "Company not found"
            ], 404);
        }
    }

    public function store(Request $request)
    {
        if(is_null($request->name)) {

            return response()->json([
                "message" => "company name is required"
            ], 400);
        }

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
        $company->save();

        return response()->json([
            "message" => "Company record created"
        ], 201);
    }

    public function update(Request $request, $id) {

        if (Company::where('id', $id)->exists()) {

            $company = Company::find($id);
            $company->name =  $request->name;
            $company->email = $request->email;
            $company->website = $request->website;
            $company->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Company not found"
            ], 404);
        }
    }

    public function delete ($id) {

        if(Company::where('id', $id)->exists()) {
            $company = Company::find($id);
            $company->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Company not found"
            ], 404);
        }
    }
}
