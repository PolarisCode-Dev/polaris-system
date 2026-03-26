<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    //Función para listar todas las compañías
    public function index()
    {
        return response()->json([
            'message' => 'List of companies retrieved successfully.',
            'data' => CompanyResource::collection(Company::orderBy('id', 'desc')->get()),
        ]);
    }

    //Función para crear una nueva compañía
    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();

        $company = Company::create($validated);

        return response()->json([
            'message' => 'Company created successfully.',
            'data' => new CompanyResource($company),
        ], 201);
    }

    //Función para mostrar los detalles de una compañía específica
    public function show(Company $company)
    {
        return response()->json([
            'message' => 'Company retrieved successfully.',
            'data' => new CompanyResource($company),
        ]);
    }

    //Función para actualizar los detalles de una compañía específica
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $validated = $request->validated();

        $company->update($validated);

        return response()->json([
            'message' => 'Company updated successfully.',
            'data' => new CompanyResource($company),
        ]);
    }

    //Función para eliminar una compañía específica
    public function destroy(Company $company)
    {
        $companyResource = new CompanyResource($company);
        $company->delete();

        return response()->json([
            'message' => 'Company deleted successfully.',
            'data' => $companyResource,
        ]);
    }
}
