<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Password; // Correct Password facade
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) use ($request) { // Use `use ($request)` to access the $request variable
                    $getEmail = DB::table('password_reset_tokens')
                    ->select('email', 'token')
                        ->get()
                        ->filter(function ($record) use ($request) {
                            return Hash::check($request->token, $record->token);
                        })
                        ->first();
        
                    if (!$getEmail) {
                        $fail('Invalid token.');
                        return;
                    }
        
                    $user = User::where('email', $getEmail->email)->first();
        
                    if (!$user) {
                        $fail('User not found.');
                    } elseif (!Hash::check($value, $user->password)) {
                        $fail('The old password is incorrect.');
                    }
                }
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $getEmail = DB::table('password_reset_tokens')
                    ->select('email', 'token')
                        ->get()
                        ->filter(function ($record) use ($request) {
                            return Hash::check($request->token, $record->token);
                        })
                        ->first();
        $user = User::where('email', $getEmail->email)->first();

    if ($user) {
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        // Delete the password reset token to prevent reuse
        DB::table('password_reset_tokens')
            ->where('email', $getEmail->email)
            ->delete();

        return redirect()->route('login')->with('status', __('Password reset successfully.'));
    }
    return back()->withInput($request->only('email'))
    ->withErrors(['email' => __('Failed to reset password.')]);
   }
}
