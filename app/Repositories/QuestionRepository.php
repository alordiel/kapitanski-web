<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionRepository extends Controller
{

    public static function getDemoQuestions(): Collection
    {
        $questions = new Question();
        return $questions->answers()
            ->where('exam_id', 2)
            ->take(20)
            ->get();
    }

    public function getQuestionsByCategory(int $category_id, int $count_of_questions): Collection
    {
        return Question::where([
            ['exam_id', '=', 1],
            ['question_category_id','=', $category_id]
            ])
            ->with('answers')
            ->take($count_of_questions)
            ->get();
    }

    public function getAllQuestions(string $type, int $count_of_questions)
    {
        if ($type === 'practice') {
            $alreadySeen = $this->getAlreadySeenQuestions();
            return Question::where('exam_id', 1)
                ->with('answers')
                ->take($count_of_questions)
                ->inRandomOrder()
                ->get();
        }

        return Question::where('exam_id', 1)
            ->with('answers')
            ->take(60)
            ->inRandomOrder()
            ->get();
    }

    public function getMistakenQuestions()
    {
        return [];
    }

    public function getAlreadySeenQuestions(int $countOfNeededQuestions): array
    {
        $question_ids = [];
        $totalQuestions = DB::table('questions')->where('exam_id', 1)->count();
        // Get all the user's questions that s/he has seen so far
        $user = Auth::user();
        $user_answers = UserAnswer::where('user_id', $user->id)
            ->select('question_id', DB::raw('COUNT(question_id) as repeated'))
            ->groupBy('question_id')
            ->orderBy('repeated')
            ->get();

        if (empty($user_answers)) {
            return [];
        }

        $countOfSeenQuestions = count($user_answers);
        // Let's first find what is the maximum number of repeating
        $maxRepeated = 1;
        foreach ($user_answers as $item) {
            $repeated = $item['repeated'];
            if ($repeated > $maxRepeated) {
                $maxRepeated = $repeated;
            }
        }

        // Check if the max is still 1 (meaning that questions were seen maximum once)
        if ($maxRepeated === 1) {
            foreach ($user_answers as $question) {
                $question_ids[] = $question['question_id'];
            }
            // It is possible that we have less than the need not_seen questions, so we need to do some repeating
            $notSeen = $totalQuestions - $countOfSeenQuestions;
            if ($notSeen < $countOfNeededQuestions) {
                $difference = $countOfNeededQuestions - $notSeen;
                shuffle($question_ids);
                array_splice($question_ids, 0, $difference);
            }

            return ['whereNOTin', $question_ids];
        }

        // Group the question IDs by number of repetitions
        $sortedByRepeat = [];
        foreach ($user_answers as $question) {
            $repeated = $question['repeated'];
            $questionId = $question['question_id'];
            if (!isset($sortedByRepeat[$repeated])) {
                $sortedByRepeat[$repeated] = [];
            }
            $sortedByRepeat[$repeated][] = $questionId;
        }
        // check if all seen questions have at same level of repeating
        if (count($sortedByRepeat) === 1 ) {
            $questions = array_values($sortedByRepeat)[0];
            $question_ids  = array_splice($questions,0, $countOfNeededQuestions);
            return ['whereIN', $question_ids];
        }

        ksort($sortedByRepeat); //sort by level (lower level first)
        foreach ($sortedByRepeat as $questions) {
            $countOfCurrentLevel = count($questions);
            // we will fill the needed questions from the lowest levels first and add from the next until we get to the needed amount
            if ($countOfNeededQuestions <= $countOfCurrentLevel){
                shuffle($questions);
                array_splice($questions,0, $countOfNeededQuestions);
                $question_ids = array_merge($question_ids, $questions);
               break;
            } else {
                $countOfNeededQuestions -= $countOfCurrentLevel;
                $question_ids = array_merge($question_ids, $questions);
            }
        }
        return ['whereIN',$question_ids];
    }

}
