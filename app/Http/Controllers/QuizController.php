<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function result() {
        return view('QuizPage.result');
    }

    public function progress($id)
    {
        $questions = [
            [
                "no" => 1,
                "question" => "1 - 1 = ....",
                "answers" => [
                    ["answer" => "0", "isright" => true],
                    ["answer" => "1", "isright" => false],
                    ["answer" => "2", "isright" => false],
                ]
            ],
            [
                "no" => 2,
                "question" => "3 × 2 = ....",
                "answers" => [
                    ["answer" => "5", "isright" => false],
                    ["answer" => "6", "isright" => true],
                ]
            ],
            [
                "no" => 3,
                "question" => "10 ÷ 2 = ....",
                "answers" => [
                    ["answer" => "2", "isright" => false],
                    ["answer" => "3", "isright" => false],
                    ["answer" => "4", "isright" => false],
                    ["answer" => "5", "isright" => true],
                    ["answer" => "6", "isright" => false],
                ]
                ],
            [
                "no" => 4,
                "question" => "2 - 1 = ....",
                "answers" => [
                    ["answer" => "0", "isright" => false],
                    ["answer" => "1", "isright" => true],
                    ["answer" => "2", "isright" => false],
                    ["answer" => "3", "isright" => false],
                ]
            ],
            [
                "no" => 5,
                "question" => "2 - 1 = ....",
                "answers" => [
                    ["answer" => "0", "isright" => false],
                    ["answer" => "1", "isright" => true],
                    ["answer" => "2", "isright" => false],
                    ["answer" => "3", "isright" => false],
                    ["answer" => "4", "isright" => false],
                    ["answer" => "5", "isright" => false],
                ]
            ]
        ];

        return view('QuizPage.quiz', compact('questions'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Data quiz versi publik (statis)
        $publicQuizzes = [
            (object) ['id' => 1, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!Uji kemampuan matematikamu!Uji kemampuan matematikamu!Uji kemampuan matematikamu!Uji kemampuan matematikamu!Uji kemampuan matematikamu!Uji kemampuan matematikamu!Uji kemampuan matematikamu!Uji kemampuan matematikamu!'],
            (object) ['id' => 2, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            (object) ['id' => 3, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!'],
            (object) ['id' => 4, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            (object) ['id' => 5, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!'],
            (object) ['id' => 6, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            (object) ['id' => 7, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!'],
            (object) ['id' => 8, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            (object) ['id' => 9, 'title' => 'Quiz Sains', 'description' => 'Jelajahi dunia sains dengan quiz ini!']
        ];

        // Data quiz dari guru (statis)
        $teacherQuizzes = [
            (object) ['id' => 10, 'title' => 'Quiz Fisika', 'description' => 'Tes pemahaman tentang fisika dasar!'],
            (object) ['id' => 11, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!'],
            (object) ['id' => 12, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            (object) ['id' => 13, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!'],
            (object) ['id' => 14, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            (object) ['id' => 15, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!'],
            (object) ['id' => 16, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            (object) ['id' => 17, 'title' => 'Quiz Biologi', 'description' => 'Seberapa banyak kamu tahu tentang biologi?']
        ];

        return view('QuizPage.index', compact('publicQuizzes', 'teacherQuizzes'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('QuizPage.detail');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
