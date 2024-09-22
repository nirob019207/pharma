<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pharmachy;
use App\Models\User;

class PharmachyController extends Controller
{
    public function index()
    {
        $pharmacies = Pharmachy::all();
        return view('admin.pharmacy.index', compact('pharmacies'));
    }

    public function create()
    {
        $users = User::all(); // Retrieve all users
        return view('admin.pharmacy.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:main,branch',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Pharmachy::create($request->all());
        return redirect()->route('pharmacies.index')->with('status', 'Pharmacy created successfully!');
    }

    public function show(Pharmachy $pharmachy)
    {
        return view('admin.pharmacy.show', compact('pharmachy'));
    }

    public function edit($id)
    {
        $pharmacy = Pharmachy::findOrFail($id);
        $users = User::all(); // Retrieve all users
        return view('admin.pharmacy.edit', compact('pharmacy', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:main,branch',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $pharmacy = Pharmachy::findOrFail($id);
        $pharmacy->update($request->all());
        return redirect()->route('pharmacies.index')->with('status', 'Pharmacy updated successfully!');
    }

    public function destroy($id)
    {
        $pharmacy = Pharmachy::findOrFail($id);
        $pharmacy->delete();
        return redirect()->route('pharmacies.index')->with('status', 'Pharmacy deleted successfully!');
    }
}
