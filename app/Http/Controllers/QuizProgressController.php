<?php

namespace App\Http\Controllers;

use App\Constants\DBTypes;
use App\Models\QuizProgress;
use App\Models\Type;
use Illuminate\Http\Request;

class QuizProgressController extends Controller
{
    protected $type;
    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function storeType4(Request $request)
    {
        $validated = $request->validate([
            'totalDuration' => 'required|integer',
            'correctCount' => 'required|integer',
            'wrongCount' => 'required|integer',
            'rps_id' => 'required|integer',
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
            'rps_id' => $validated['rps_id'],
            'type_quiz_id' => $this->type->getIdByCode(DBTypes::QuizType4)
        ]);

        return response()->json(['message' => 'Progres berhasil disimpan.']);
    }

    public function storeType3(Request $request)
    {
        $validated = $request->validate([
            'totalDuration' => 'required|integer',
            'correctCount' => 'required|integer',
            'wrongCount' => 'required|integer',
            'rps_id' => 'required|integer',
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
            'rps_id' => $validated['rps_id'],
            'type_quiz_id' => $this->type->getIdByCode(DBTypes::QuizType3)
        ]);

        return response()->json(['message' => 'Progres berhasil disimpan.']);
    }

    public function storeType2(Request $request)
    {
        $validated = $request->validate([
            'totalDuration' => 'required|integer',
            'correctCount' => 'required|integer',
            'wrongCount' => 'required|integer',
            'rps_id' => 'required|integer',
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
            'rps_id' => $validated['rps_id'],
            'type_quiz_id' => $this->type->getIdByCode(DBTypes::QuizType2)
        ]);

        return response()->json(['message' => 'Progres berhasil disimpan.']);
    }

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
    public function store(Request $request) {}

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
