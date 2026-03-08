<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:admins,username',
            'email' => 'required|email|max:100|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:100',
            'role' => 'required|in:admin,editor',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 'active';

        $admin = Admin::create($validated);

        ActivityLog::log('admin', 'create', "Created admin: {$admin->username}");

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:admins,email,' . $admin->id,
            'role' => 'required|in:admin,editor',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        ActivityLog::log('admin', 'update', "Updated admin: {$admin->username}");

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $username = $admin->username;
        $admin->delete();

        ActivityLog::log('admin', 'delete', "Deleted admin: {$username}");

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully.');
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.admins.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:admins,email,' . $admin->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $admin->password = Hash::make($validated['new_password']);
        }

        $admin->full_name = $validated['full_name'];
        $admin->email = $validated['email'];
        $admin->save();

        ActivityLog::log('admin', 'profile_update', "Admin '{$admin->username}' updated profile");

        return back()->with('success', 'Profile updated successfully.');
    }
}
