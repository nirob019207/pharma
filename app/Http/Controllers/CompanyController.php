<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;


class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('admin.company.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.company.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'unique:companies,name']]);
        Company::create([
            "name" => $request->name
        ]);
        return redirect('companies')->with('status', "Company created successfully");
    }

    public function edit($id)
    {
        $companies = Company::findOrFail($id);
        return view('admin.company.edit', compact('companies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => ['required', 'string', 'unique:companies,name,' . $id]]);
        $companies = Company::findOrFail($id);
        $companies->update([
            "name" => $request->name
        ]);
        return redirect('companies')->with('status', "Company updated successfully");
    }

    public function destroy($id)
    {
        $companies = Company::findOrFail($id);
        $companies->delete();
        return redirect('companies')->with('status', "Company deleted successfully");
    }
}
