<?php

namespace App\Http\Controllers\API;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamTaking;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExamController
{
    public function __construct(protected QuestionRepository $questions)
    {

    }


    public function manageQuestions(Request $request): JsonResponse
    {

        if (!$request->user()->hasPermissionTo('create-exams')) {
            return response()->json([
                'message' => 'No permission to create questions',
            ], 403);
        }

        $request->validate([
            'examId' => ['required', 'numeric'],
            'questions' => 'required'
        ]);

        $exam = Exam::find($request->input('examId'));
        $questions = $request->input('questions');

        foreach ($questions as &$question_entry) {
            // create the question if it doesn't exist
            if ((int)$question_entry['id'] === 0) {
                $question = new Question();
                $question->exam_id = $exam->id;
            } else {
                $question = Question::find($question_entry['id']);
            }

            $question->question = $question_entry['body'];
            $question->type = $question_entry['type'];
            $question->question_category_id = $question_entry['category'];
            $question->save();

            // $question->questionCategory()->save($questionCategory);
            // $exam->question()->save($question);
            $question_entry['id'] = $question->id;

            // saving the answers
            $answersType = $question_entry['type'] === 'text' ? 'textAnswers' : 'imageAnswers';
            foreach ($question_entry[$answersType] as &$answer_entry) {
                if (empty($answer_entry['content'])) {
                    continue;
                }
                // check if the current answer doesn't have and ID and create one for it
                if ((int)$answer_entry['id'] === 0) {
                    $answer = new Answer(['answer' => $answer_entry['content']]);
                    $answer->save();
                    $answer_entry['id'] = $answer->id;
                } else {
                    $answer = Answer::find($answer_entry['id']);
                    $answer->answer = $answer_entry['content'];
                    $answer->save();
                }

                // store the correct answer
                if ($answer_entry['isCorrect']) {
                    $question->correct_answer = $answer->id;
                }
                // connect the answer to the question
                $question->save();
                $question->answers()->save($answer);
            } // end foreach answer
            unset($answer_entry);

        } // end foreach question

        return response()->json([
            'message' => 'All updated successfully',
            'questions' => $questions,
        ], 201);
    }


    public function getExamQuestions(Request $request): JsonResponse
    {
        if (!$request->user()->hasPermissionTo('take-exam')) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No permission to take exam'
            ], 403);
        }

        // Validate the request
        $request->validate([
            'type' => 'required',
        ]);

        $questions = [];
        // Check what is the type of the exam and what questions we need to provide
        switch ($request->input('type')) {
            case 'practice':
                $data = $request->validate([
                    'numberOfQuestions' => 'required',
                    'categoryID' => ['required', 'numeric'],
                ]);
                if ((int)$data['categoryID'] === -1) {
                    $questions = $this->questions->getAllQuestions('practice', $data['numberOfQuestions']);
                } else {
                    $questions = $this->questions->getQuestionsByCategory($data['categoryID'], $data['numberOfQuestions']);
                }
                break;
            case 'real':
                $questions = $this->questions->getAllQuestions('real', 60);
                break;
            case 'mistaken':
                $questions = $this->questions->getMistakenQuestions();
        }


        return response()->json([
            'status' => 'success',
            'exam' => $questions,
        ], 201);
    }

    public function getDemoExamQuestions(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'results' => QuestionRepository::getDemoQuestions(),
        ], 201);
    }

    public function submitExam(Request $request): JsonResponse
    {
        if (!$request->user()->hasPermissionTo('take-exam')) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No permission to take exam'
            ], 403);
        }

        // Validate the request
        $request->validate([
            'exam' => 'required',
            'examId' => 'required',
            'examType' => 'required',
            'results' => 'required',
        ]);
        $results = $request->input('results');
        $exam = $request->input('exam');
        // Save the exam taking
        $exam_taking = ExamTaking::create([
            'user_id' => $request->user()->id,
            'exam_id' =>  $request->input('examId'),
            'exam_type' =>  $request->input('examType'),
            'result' => (int) $results['score'],
            'total_questions' => (int) $results['totalQuestions'],
            'wrong_answers' => (int) $results['wrong']
        ]);
        // Save each user's answer
        foreach ($exam as $question){
            UserAnswer::create([
                'user_id' => $request->user()->id,
                'exam_taking_id' => $exam_taking->id,
                'question_id' => $question['questionId'],
                'answer_id' => $question['userAnswer'],
                'is_correct' => $question['isCorrect'],
            ]);
        }

        if ($results['score'] >= 90) {
            $finalMessage = sprintf(__("You have passed with %d%% of correct answers."), $results['score']);
        } else {
            $finalMessage = sprintf(__("You have failed the test. You've got %d wrong answers out of %d questions with final score of %d%%."), $results['wrong'], $results['totalQuestions'], $results['score']);
        }

        return response()->json([
            'status' => 'success',
            'results' => $finalMessage,
        ], 201);
    }
}
