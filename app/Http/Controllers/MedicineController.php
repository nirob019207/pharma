<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Company;
use App\Models\Generic;

class MedicineController extends Controller
{
    public function index()
    {
        // Eager-load related models to optimize performance
        $medicines = Medicine::with('generic', 'company')->get();
        return view('admin.medicine.index', compact('medicines'));
    }

    public function create()
    {
        $generics = Generic::all();
        $companies = Company::all();
        return view('admin.medicine.create', [
            'companies' => $companies,
            'generics' => $generics
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'generic_id' => 'required|integer|exists:generics,id',
            'company_id' => 'required|integer|exists:companies,id',
            'description' => 'nullable|string',
        ]);

        Medicine::create($request->all());
        return redirect()->route('medicines.index')->with('status', 'Medicine added successfully!');
    }

    public function show(Medicine $medicine)
    {
        // Eager-load related models
        $medicine->load('generic', 'company');
        return view('admin.medicine.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        // Eager-load related models
        $medicine->load('generic', 'company');
        $generics = Generic::all();
        $companies = Company::all();
        return view('admin.medicine.edit', [
            'medicine' => $medicine,
            'generics' => $generics,
            'companies' => $companies
        ]);
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'generic_id' => 'required|integer|exists:generics,id',
            'company_id' => 'required|integer|exists:companies,id',
            'description' => 'nullable|string',
        ]);

        $medicine->update($request->all());
        return redirect()->route('medicines.index')->with('status', 'Medicine updated successfully!');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('medicines.index')->with('status', 'Medicine deleted successfully!');
    }
}
