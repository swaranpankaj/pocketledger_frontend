<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountSetupController extends Controller
{
    /**
     * Show the account setup page.
     */
    public function showSetupAccount(Request $request)
    {
        // Retrieve authenticated user
        $user = Auth::user();

        // If no user is logged in, redirect to login page
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        return view('auth.setup-account', compact('user'));
    }

    public function completeAccountSetup(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
        ]);
        $user = Auth::user(); // Get authenticated user

        // Update user details
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
        ]);
        return response()->json(['success' => true, 'message' => 'Account setup complete!']);
    }
}