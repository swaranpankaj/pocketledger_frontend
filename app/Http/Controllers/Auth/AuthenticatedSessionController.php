<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */


    public function store(LoginRequest $request): Response|RedirectResponse|JsonResponse
    {
        try {
            $request->authenticate(); // Attempt to authenticate the user
            
            $request->session()->regenerate(); // Regenerate session to prevent session fixation attacks

            return response()->json([
                'success' => true,
                'message' => 'Login successfully.'
            ]);
        } catch (ValidationException $e) {
            // Return error message if authentication fails
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 500);
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
