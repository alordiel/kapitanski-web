<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('exam.index', [
            'exams' => Exam::all()
        ]);
    }

    public function create(): View
    {
        return view('exam.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $formFields = $request->validate([
            'name' => 'required',
        ]);

        Exam::create($formFields);

        return redirect('/admin/exams')->with('message', 'Exam successfully created');
    }

    public function show(Exam $exam): View
    {
        return view('exam.show', ['exam' => $exam]);
    }

    public function questions(Exam $exam): View
    {
        return view('exam.questions', ['exam' => $exam]);
    }

    public function edit(Exam $exam): View
    {
        return view('exam.edit', ['exam' => $exam]);
    }

    public function update(Request $request, Exam $exam): RedirectResponse
    {
        $formFields = $request->validate([
            'name' => 'required',
        ]);

        $exam->update($formFields);

        return back()->with('message', 'Exam updated successfully!');
    }

    public function destroy(Exam $exam): RedirectResponse
    {
        $exam->delete();
        return redirect('/admin/exams')->with('message', 'Deleted successfully');
    }

    public function manageQuestions(Request $request): JsonResponse
    {

        if(!$request->user()->hasPermissionTo('create-exams')) {
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
            'showCorrectAnswer' => 'required',
            'showExplanation' => 'required',
        ]);


        // Check what is the type of the exam and what questions we need to provide


        return response()->json([
            'status' => 'success',
            'exam' => [],
        ], 201);
    }

    public function getDemoExamQuestions(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'exam' => [],
        ], 201);
    }
}
