<?php

namespace App\Http\Controllers;

use App\Models\QuizSetting;
use Illuminate\Http\Request;

class QuizSettingController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizSetting $quizSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuizSetting $quizSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $setting = QuizSetting::find($id); // atau berdasarkan ID jika lebih spesifik

        $field = $request->input('field');
        $value = $request->input('value');

        if (in_array($field, ['jumlah_soal', 'batas_waktu', 'attempt_quiz', 'soal_per_sesi'])) {
            $setting->$field = $value;
            $setting->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizSetting $quizSetting)
    {
        //
    }
}
