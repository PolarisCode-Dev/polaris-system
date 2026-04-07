<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 200,
            'message' => 'Companies loaded successfully.',
            'data' => CompanyResource::collection(Company::orderBy('id', 'desc')->get()),
        ], 200);
    }

    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();

        $company = Company::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Company created successfully.',
            'data' => new CompanyResource($company),
        ], 201);
    }

    public function show(Company $company)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Company retrieved successfully.',
            'data' => new CompanyResource($company),
        ], 200);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $validated = $request->validated();

        $company->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Company updated successfully.',
            'data' => new CompanyResource($company),
        ], 200);
    }

    public function destroy(Company $company)
    {
        $companyResource = new CompanyResource($company);
        $company->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Company deleted successfully.',
            'data' => $companyResource,
        ], 200);
    }
}
