<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // For hashing passwords
use Illuminate\Support\Facades\Log; // Import Log facade

class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        $admin = AdminModel::where('username', $validated['username'])->first();

        if ($admin && Hash::check($validated['password'], $admin->password)) {
            $request->session()->put('adminId', $admin->uuid);

            Log::info('User logged in successfully.', [
                'username' => $validated['username'],
                'user_id' => $admin->uuid
            ]);

            return redirect()->route('admin.positions');
        }
        else {
            Log::warning('Invalid login attempt.', [
                'username' => $validated['username'],
                'timestamp' => now()
            ]);
    
            return back()->withErrors(['message' => 'Invalid username or password!']);
        }
    }

    public function logout() 
    {
        session()->forget('adminId');
        session()->flush();

        return redirect()->route('admin.auth');
    }
}
 