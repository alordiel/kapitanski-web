<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class QuestionController extends Controller
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
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }

    public static function getDemoQuestions(): Collection
    {
        $questions = new Question();
        return $questions->answers()->where('exam_id', 2)->take(20)->get();
    }

    public function getQuestionsByCategory(int $category_id, int $count_of_questions): Collection
    {
        $questions = new Question();
        return $questions->answers()
            ->where('question_category_id', $category_id)
            ->take($count_of_questions)
            ->get();
    }

    public function getAllQuestions(string $type, int $count_of_questions)
    {
        if($type === 'all') {
            $questions = Question::where('exam_id', 1)->take(-1)->get();
        } else {
            $questions = Question::where('exam_id', 1)->take($count_of_questions)->get();
        }

        return $questions;
    }

    public function getMistakenQuestions()
    {

    }
}
