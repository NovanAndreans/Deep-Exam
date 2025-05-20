<?php

namespace App\Http\Controllers;

use App\Models\QuizProgress;
use Illuminate\Http\Request;

class QuizProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'totalDuration' => 'required|integer',
            'correctCount' => 'required|integer',
            'wrongCount' => 'required|integer',
            'correctPercent' => 'required|numeric',

            'timeSpendSessions' => 'nullable|array',
            'userSkipQuestionSessions' => 'nullable|array',
            'userChangeAnswerSessions' => 'nullable|array',
            'userHintSessions' => 'nullable|array',
        ]);

        QuizProgress::create([
            'user_id' => auth()->id(),
            'total_duration' => $validated['totalDuration'],
            'correct_count' => $validated['correctCount'],
            'wrong_count' => $validated['wrongCount'],
            'correct_percent' => $validated['correctPercent'],
            'time_spend_sessions' => $validated['timeSpendSessions'],
            'skip_question_sessions' => $validated['userSkipQuestionSessions'],
            'change_answer_sessions' => $validated['userChangeAnswerSessions'],
            'hint_sessions' => $validated['userHintSessions'],
        ]);

        return response()->json(['message' => 'Progres berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizProgress $quizProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuizProgress $quizProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuizProgress $quizProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizProgress $quizProgress)
    {
        //
    }
}
