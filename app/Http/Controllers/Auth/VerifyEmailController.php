<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */

     public function showVerificationPage()
     {
         Log::info('Controller: Email verification page visited.');
 
         // Check session
         Log::info('Controller session data:', ['session' => session()->all()]);
 
         $user = User::find(session('unverified_user_id'));
 
         if (!$user) {
             Log::error('Controller: No user found in session.');
             return redirect()->route('signup')->with('error', 'Please sign up first.');
         }
 
         Log::info('Controller: User found', ['user_id' => $user->id]);
 
         return view('auth.verify-email', compact('user'));
     }

     public function verify(Request $request, $id, $hash): Response|RedirectResponse|JsonResponse
     {
         try {
            
             $request->validate([
                 'verification_code' => 'required',
             ]);
     
             $user = User::find($id);
          
             if (!$user) {
                 return response()->json(['success' => false, 'message' => 'User not found.']);
             }
             
             if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
                return response()->json(['success' => false, 'message' => 'Invalid verification link.']);
             }
             if ($user->verification_code !== $request->input('verification_code')) {
                return response()->json(['success' => false, 'message' => 'Invalid Verification code.']);
             }
             if (!$user->email_verified_at) {
                 $user->markEmailAsVerified();
                 event(new Verified($user));
             }
     
             if (!Auth::check()) {
                 Auth::login($user);
             }
     
             return response()->json(['success' => true, 'message' => 'Email verified successfully.']);
         } catch (Exception $e) {
             return response()->json(['success' => false, 'message' => $e->getMessage()]);
         }
     }
     
}
