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
        $centerExecutive = Role::query()->where('name', 'Center Executive')->first();

        $centerexes = User::query()->where('role_id', $centerExecutive->id)
            ->where('status', 1)
            ->get();

        return view('admin.centers.create', compact('centerexes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'center_code' => 'required|string|max:255',
            'center_name' => 'nullable|string|max:255',
            'center_exe_id' => 'nullable|exists:users,id',
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
        $centerexes = User::query()->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.centers.edit', compact('center', 'centerexes'));
    }

    public function update(Request $request, Center $center)
    {
        $validated = $request->validate([
            'center_code' => 'required|string|max:50|unique:centers,center_code,'.$center->id,
            'center_name' => 'required|string|max:255',
            'center_exe_id' => 'nullable|exists:users,id',
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

    public function destroy(Center $center)
    {
        $center->update([
            'status' => 0,
        ]);

        return redirect()
            ->route('centers.index')
            ->with('success', 'Center deactivated successfully.');
    }
}
