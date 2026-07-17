<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function index()
    {
        $centers = Center::with('manager')->latest()->get();

        return view('admin.centers.index', compact('centers'));
    }

    public function create()
    {
        $managerRole = Role::query()->where('name', 'manager')->first();

        $managers = User::query()->where('role_id', $managerRole->id)
            ->where('status', 1)
            ->get();

        return view('admin.centers.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'center_code' => 'required|string|max:255',
            'center_name' => 'nullable|string|max:255',
             'manager_id'  => 'nullable|exists:users,id',
            'address' => 'nullable|string|max:20',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'pincode' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable|email|max:255',
        ]);
        $validated['status'] = 1;

        Center::create($validated);

        return redirect()
            ->route('centers.index')
            ->with('success', 'Center added successfully.');
    }

    public function edit(Center $center)
    {
        $managers = User::query()->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.centers.edit', compact('center', 'managers'));
    }

    public function update(Request $request, Center $center)
    {
        $validated = $request->validate([
            'center_code' => 'required|string|max:50|unique:centers,center_code,'.$center->id,
            'center_name' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:users,id',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'status' => 'required|boolean',
        ]);

        $center->update($validated);

        return redirect()
            ->route('centers.index')
            ->with('success', 'Center updated successfully.');
    }
}
