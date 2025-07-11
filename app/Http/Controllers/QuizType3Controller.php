<?php

namespace App\Http\Controllers;

use App\Constants\AiText;
use App\Models\Quiz;
use App\Models\QuizSetting;
use App\Models\Rps;
use App\Models\SubCpmk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizType3Controller extends Controller
{
    protected $rps, $subCpmk, $quizSetting;
    public function __construct(Rps $rps, SubCpmk $subCpmk, QuizSetting $quizSetting)
    {
        $this->rps = $rps;
        $this->subCpmk = $subCpmk;
        $this->quizSetting = $quizSetting;
    }

    public function generateFirstQuestion($subCpmkId, $bloomLevel)
    {
        // Dummy data, seolah-olah dari Gemini
        $questions = [];
        // for ($i = 1; $i <= 3; $i++) {
        //     $questions[] = [
        //         'question' => "First Soal ke-$i dari Sub-CPMK $subCpmkId, level Bloom $bloomLevel",
        //         'answers' => [
        //             ['answer' => "Jawaban A", 'isright' => false],
        //             ['answer' => "Jawaban B", 'isright' => true],
        //             ['answer' => "Jawaban C", 'isright' => false],
        //             ['answer' => "Jawaban D", 'isright' => false],
        //         ]
        //     ];
        // }
        $subCpmkQuestion = $this->quizSetting->where('rps_id', $subCpmkId->cpmk_id)->first()
            ->soal_per_sesi;

        $jsonString  = $this->generateAI(AiText::GenerateQuestion($subCpmkId, $bloomLevel, $subCpmkQuestion));

        $jsonString = preg_replace('/```(?:json)?|```/i', '', $jsonString);
        $jsonString = trim($jsonString);

        $questions = json_decode($jsonString);

        return $questions;
    }

    public function generateQuestion(Request $request)
    {
        $subCpmkId = $request->query('subcpmk');
        $bloomLevel = $request->query('limit_bloom');
        // Dummy data, seolah-olah dari Gemini

        $rpsId = $this->subCpmk->find($subCpmkId)->cpmk_id;
        $subCpmkQuestion = $this->quizSetting->where('rps_id', $rpsId)->first()->soal_per_sesi;
        $subCpmkId = $this->subCpmk->find($subCpmkId)->subcpmk;

        $jsonString  = $this->generateAI(AiText::GenerateQuestion($subCpmkId, $bloomLevel, $subCpmkQuestion));

        $jsonString = preg_replace('/```(?:json)?|```/i', '', $jsonString);
        $jsonString = trim($jsonString);

        $questions = json_decode($jsonString);
        Log::info($questions);

        return response()->json($questions);
    }


    public function result()
    {
        return view('QuizPageType3.result');
    }

    public function progress($id)
    {
        $id = decrypt($id);
        $subCpmks = $this->subCpmk->where('cpmk_id', $id)->orderBy('limit_bloom', 'asc')->get();

        $firstCpmks = collect($subCpmks)->first()->id;

        $firstLimitBloom = optional($subCpmks->first())->limit_bloom ?? 1;

        $setting = $this->quizSetting->where('rps_id', $id)->first();

        $id2 = $id;
        $id = encrypt($id);
        $predictUrl = config('api.predict_url');
        return view('QuizPageType3.quiz', compact('predictUrl', 'firstCpmks', 'firstLimitBloom', 'subCpmks', 'id', 'id2', 'setting'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Data quiz versi publik (statis)
        $publicQuizzes = $this->rps->all();

        // Data quiz dari guru (statis)
        $teacherQuizzes = [
            // (object) ['id' => 10, 'title' => 'Quiz Fisika', 'description' => 'Tes pemahaman tentang fisika dasar!'],
            // (object) ['id' => 11, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!'],
            // (object) ['id' => 12, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            // (object) ['id' => 13, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!'],
            // (object) ['id' => 14, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            // (object) ['id' => 15, 'title' => 'Quiz Matematika', 'description' => 'Uji kemampuan matematikamu!'],
            // (object) ['id' => 16, 'title' => 'Quiz Sejarah', 'description' => 'Seberapa baik kamu mengenal sejarah?'],
            // (object) ['id' => 17, 'title' => 'Quiz Biologi', 'description' => 'Seberapa banyak kamu tahu tentang biologi?']
        ];



        return view('QuizPageType3.index', compact('publicQuizzes', 'teacherQuizzes'));
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
        $id = decrypt($id);
        $data = $this->rps->with(['creator', 'subCpmk', 'quizSetting', 'meeting' => function ($query) {
            $query->with(['kisi']);
        }])->find($id);

        return view('QuizPageType3.detail', compact('data'));
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
