<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Mail\NewCompanyEmail;
use App\Models\Company;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::orderBy('id', 'desc')->paginate(10);
        return CompanyResource::collection($companies);
    }


     /**
     * Display a listing of the resource.
     */
    public function allCompanies()
    {
        $companies = Company::orderBy('id', 'desc')->get();
        return CompanyResource::collection($companies);

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
            'name' => 'required',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|url',
        ]);

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('logos', 'public');
            $company->logo = $logoPath;
        }
        $company->website = $request->website;
        $company->save();
        $fromAddress = Config::get('mail.from.address');
        if($company->email) {
            Mail::to($company->email)->send(new NewCompanyEmail($company, $fromAddress, $company->email));
        }

        return response()->json([
            'message' => 'Company created successfully.',
            'data' => new CompanyResource($company)
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
            'name' => 'required',
            'removeImage' => 'required',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|url',
        ]);

        $company = Company::find($id);
        if (!$company) {
            return response()->json([
                'message' => 'Company not found.'
            ],400);
        }
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->website = $request->input('website');

        if($request->removeImage == 1) {
            $company->logo = null;
        } else {
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoPath = $logo->store('logos', 'public');
                $company->logo = $logoPath;
            }
        }
        $company->save();
        return response()->json([
            'message' => 'Company updated successfully.',
            'data' => new CompanyResource($company)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json([
                'message' => 'Company not found.'
            ],400);
        }
        $company->delete();
        return response()->json([
            'message' => 'Company deleted successfully.'
        ],200);
    }
}
