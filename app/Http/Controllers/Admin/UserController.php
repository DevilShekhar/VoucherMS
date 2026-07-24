<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('role')
            ->latest()
            ->paginate(20);
        $active = User::query()->where('status', 1)->count();
        $inactive = User::query()->where('status', 0)->count();

        return view('admin.users.index', compact('users', 'active', 'inactive'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $roles = Role::query()->where('status', 1)
            ->where('name', '!=', 'Super Admin')
            ->orderBy('name')
            ->get();
        $locations = Location::orderBy('name')->get();

        return view('admin.users.create', compact('roles', 'locations'));
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'employee_code' => 'required|string|max:50|unique:users,employee_code',
            'name' => 'required|string|max:255',
            'location_id' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:20|unique:users,mobile|regex:/^[0-9+\-\s]+$/',
            'password' => 'required|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['status'] = 1;

        if ($request->hasFile('profile_photo')) {

            $validated['profile_photo'] = $request
                ->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);

        $newUser = User::create($validated);

        $role = Role::findOrFail($validated['role_id']);
        $newUser->assignRole($role);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(User $user)
    {
        $roles = Role::query()->where('status', 1)
            ->orderBy('name')
            ->get();
        $locations = Location::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles', 'locations'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'employee_code' => 'required|string|max:50|unique:users,employee_code,'.$user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'mobile' => 'required|string|max:20|unique:users,mobile,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $validated['status'] = $request->status;

        if ($request->hasFile('profile_photo')) {

            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {

                Storage::disk('public')->delete($user->profile_photo);
            }

            $validated['profile_photo'] = $request
                ->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        if (! empty($validated['password'])) {

            $validated['password'] = Hash::make($validated['password']);

        } else {

            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {

            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
