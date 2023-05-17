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
        $request->validate([
            'examId' => ['required', 'numeric'],
            'questions' => 'required'
        ]);

        $examId = $request->input('examId');
        $exam = Exam::find($examId);
        $questions = $request->input('questions');

        foreach ($questions as $single_question) {
            // create the question if it doesn't exist
            if ( (int) $single_question['id'] === 0) {
                $question = new Question([
                    'question' =>$single_question['body'],
                    'type' => $single_question['type'],
                ]);
            } else {
                $question = Question::find($single_question['id']);
            }
            // saving the text answers
            if ($single_question['type'] === 'text') {
                foreach ($single_question['textAnswers'] as $single_answer) {
                    if ((int)$single_answer['id'] === 0) {
                        $answer = new Answer(['answer' => $single_answer['text']]);
                        $single_answer['id'] = $answer->id;
                    } else {
                        $answer = Answer::find($single_answer['id']);
                        $answer->answer = $single_answer['text'];
                        $answer->save();
                    }
                    $question->answer()->save($answer);
                }
            } else {

            }
            $exam->question()->save($question);
            // check if the current question is a new one, or we are updating
        }


        return response()->json([
            'message' => 'connected successfully'
        ], 201);
    }
}
