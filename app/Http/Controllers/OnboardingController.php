<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\Nominee;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Log;

class OnboardingController extends Controller
{
    public function submitQuestion(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'question_id' => 'required|exists:onboarding_question,id',
            'selected_options' => 'required|array',
        ]);
    
        $userId = auth()->id(); // Get the logged-in user ID

    foreach ($validatedData['selected_options'] as $optionId) {
        // Check if the record already exists
        $existingAnswer = UserAnswer::where('user_id', $userId)
            ->where('question_id', $validatedData['question_id'])
            ->where('answer_id', $optionId)
            ->first();

        if ($existingAnswer) {
            // Update the existing answer
            $existingAnswer->updated_at = now();
            $existingAnswer->save();
        } else {
            // Insert a new record if no existing record is found
            UserAnswer::create([
                'user_id' => $userId,
                'question_id' => $validatedData['question_id'],
                'answer_id' => $optionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
        // Redirect to the next modal or wherever you'd like
        // return redirect()->back()->with('success', 'Your answers have been saved.');
        return response()->json(['success' => true, 'message' => 'Question submitted successfully']);
    }
    
    public function submitNominee(Request $request)
{
    try {
        // Validate the request
        $validatedData = $request->validate([
            'id' => ['nullable', 'exists:nominees,id'], // Check if id exists in the nominees table
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email_address' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:10', 'regex:/^\d{10}$/'],
            'relationship' => ['nullable', 'string', 'max:255'],
            'status' => 'required',
        ]);

        $userId = auth()->id(); // Get the logged-in user ID

        if (isset($validatedData['id'])) {
            // Update the existing nominee
            $nominee = Nominee::where('id', $validatedData['id'])
                ->where('user_id', $userId) // Ensure the nominee belongs to the current user
                ->first();

            if ($nominee) {
                $nominee->update([
                    'first_name' => $validatedData['first_name'],
                    'last_name' => $validatedData['last_name'],
                    'email_address' => $validatedData['email_address'],
                    'phone_number' => $validatedData['phone_number'],
                    'relationship' => $validatedData['relationship'],
                    'status' => $validatedData['status'],
                    'updated_at' => now(),
                ]);

                return response()->json(['success' => true, 'message' => 'Nominee updated successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Nominee not found.']);
            }
        } else {
            // Create new nominee
            Nominee::create([
                'user_id' => $userId,
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email_address' => $validatedData['email_address'],
                'phone_number' => $validatedData['phone_number'],
                'relationship' => $validatedData['relationship'],
                'status' => $validatedData['status'],
                'created_at' => now(),
                'updated_at' => now(),
                
            ]);

            return response()->json(['success' => true, 'message' => 'Nominee created successfully.']);
        }
    } catch (Exception $e) {
        Log::error('Logging error data', ['exception' => $e]);

        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

    public function submitVerification(Request $request)
    {
        try {
            // Validate the mobile number and email conditionally
            $validatedData = $request->validate([
                'mobile_number_verification' => ['nullable', 'string', 'regex:/^\d{12,15}$/'],
                'backup_email' => ['nullable', 'email', 'max:255'],
            ]);

            Log::info('Validation found', $validatedData);

            // Ensure user is authenticated
            if (!auth()->check()) {
                return response()->json(['success' => false, 'message' => 'User not authenticated']);
            }

            // Find the user's profile
            $userProfile = UserProfile::where('user_id', auth()->id())->first();
            Log::info('User profile found', $userProfile ? $userProfile->toArray() : []);

            if ($userProfile) {
                // Update only the provided fields
                $updateData = [];
                if (!empty($validatedData['mobile_number_verification'])) {
                    $updateData['mobile_number_verification'] = $validatedData['mobile_number_verification'];
                }
                if (!empty($validatedData['backup_email'])) {
                    $updateData['backup_email'] = $validatedData['backup_email'];
                }
                $updateData['updated_at'] = now();
                
                $userProfile->update($updateData);
            } else {
                // Create a new profile with both fields if they are provided
                UserProfile::create([
                    'user_id' => auth()->id(),
                    'mobile_number_verification' => $validatedData['mobile_number_verification'] ?? null,
                    'backup_email' => $validatedData['backup_email'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Your profile has been saved.']);
        } catch (Exception $e) {
            Log::error('Logging error data', ['exception' => $e]);

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}
