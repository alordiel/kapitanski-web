<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionRepository extends Controller
{

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
            $questions = Question::where('exam_id', 1)
                ->with('answers')
                ->take(-1)
                ->get();
        } else {
            $questions = Question::where('exam_id', 1)
                ->with('answers')
                ->take($count_of_questions)
                ->get();
        }

        return $questions;
    }

    public function getMistakenQuestions()
    {

    }

}
