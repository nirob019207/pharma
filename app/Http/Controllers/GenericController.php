<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Generic;


class GenericController extends Controller
{
    public function index()
    {
        $generics = Generic::all();
        return view('admin.generic.index', compact('generics'));
    }

    public function create()
    {
        return view('admin.generic.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'unique:generics,name']]);
        Generic::create([
            "name" => $request->name
        ]);
        return redirect('generics')->with('status', "Generic created successfully");
    }

    public function edit($id)
    {
        $generics = Generic::findOrFail($id);
        return view('admin.generic.edit', compact('generics'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => ['required', 'string', 'unique:generics,name,' . $id]]);
        $generics = Generic::findOrFail($id);
        $generics->update([
            "name" => $request->name
        ]);
        return redirect('generics')->with('status', "Generic updated successfully");
    }

    public function destroy($id)
    {
        $generics = Generic::findOrFail($id);
        $generics->delete();
        return redirect('generics')->with('status', "Generic deleted successfully");
    }
}

