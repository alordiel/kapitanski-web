<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionCategory;
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

        $exam = Exam::find($request->input('examId'));
        $questions = $request->input('questions');

        foreach ($questions as $question_entry) {
            // create the question if it doesn't exist
            if ((int)$question_entry['id'] === 0) {
                $question = new Question([
                    'question' => $question_entry['body'],
                    'type' => $question_entry['type'],
                ]);
            } else {
                $question = Question::find($question_entry['id']);
            }

            // saving the answers
            $answersType = $question_entry['type'] === 'text' ? 'textAnswers' : 'imageAnswers';
            foreach ($question_entry[$answersType] as $answer_entry) {
                if (empty($answer_entry['content'])) {
                    continue;
                }
                // check if the current answer doesn't have and ID and create one for it
                if ((int)$answer_entry['id'] === 0) {
                    $answer = new Answer(['answer' => $answer_entry['content']]);
                    $answer_entry['id'] = $answer->id;
                    $question->answer()->save($answer);
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
                $question->answer()->save($answer);
            } // end foreach answer

            // connect the question category to the question
            $questionCategory = QuestionCategory::find($question_entry['category']);
            $questionCategory->question()->save($question);
            // $question->questionCategory()->save($questionCategory);
            $exam->question()->save($question);

        } // end foreach question


        return response()->json([
            'message' => 'All updated successfully',
            'questions' => $questions,
        ], 201);
    }
}
