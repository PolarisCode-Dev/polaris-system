<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComanyRequest;
use App\Http\Requests\UpdateComanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Lista de compañías cargadas.',
            'data' => CompanyResource::collection(Company::orderBy('id', 'desc')->get()),
        ]);
    }

    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();

        $company = Company::create($validated);

        return response()->json([
            'message' => 'Compañía creada exitosamente.',
            'data' => new CompanyResource($company),
        ], 201);
    }

    public function show(Company $company)
    {
        return response()->json([
            'message' => 'Compañía obtenida exitosamente.',
            'data' => new CompanyResource($company),
        ]);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $validated = $request->validated();

        $company->update($validated);

        return response()->json([
            'message' => 'Compañía actualizada exitosamente.',
            'data' => new CompanyResource($company),
        ]);
    }

    public function destroy(Company $company)
    {
        $companyResource = new CompanyResource($company);
        $company->delete();

        return response()->json([
            'message' => 'Compañía eliminada exitosamente.',
            'data' => $companyResource,
        ]);
    }
}
