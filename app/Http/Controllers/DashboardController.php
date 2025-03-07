<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Question;
use App\Models\Pages;
use App\Models\UserAnswer;
use App\Models\Nominee;
use App\Models\UserProfile;

class DashboardController extends Controller
{
    public function create() {
    
        $userId = Auth::id(); 
        $questions = Question::with('options','userAnswers')->where('status', true)->where('type', 'onbording')->get();
        $answeredQuestions = UserAnswer::where('user_id', $userId)
        ->select('question_id', 'answer_id')
        ->get();
        $nominee = Nominee::where('user_id', $userId)->first();
        $userProfile = UserProfile::where('user_id', $userId)->first();
        $pageStep1=Pages::first();
        $pageAllData = Pages::skip(1)->limit(PHP_INT_MAX)->get();
       return view('dashboard', compact('questions','pageStep1','pageAllData','answeredQuestions','nominee','userProfile'));

    }
    
}    