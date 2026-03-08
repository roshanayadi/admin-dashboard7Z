<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'nullable|email|max:100|unique:users,email',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ]);

        $user = User::create($validated);

        ActivityLog::log('user', 'create', "Created user: {$user->full_name}");

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'email' => 'nullable|email|max:100|unique:users,email,' . $user->id,
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ]);

        $user->update($validated);

        ActivityLog::log('user', 'update', "Updated user: {$user->full_name}");

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $name = $user->full_name;
        $user->delete();

        ActivityLog::log('user', 'delete', "Deleted user: {$name}");

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
