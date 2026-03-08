<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            $admin = Auth::guard('admin')->user();
            $admin->update(['last_login' => now()]);

            ActivityLog::log('auth', 'login', "Admin '{$admin->username}' logged in");

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Invalid credentials.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            ActivityLog::log('auth', 'logout', "Admin '{$admin->username}' logged out");
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
