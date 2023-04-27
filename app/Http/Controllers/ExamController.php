<?php

namespace App\Http\Controllers;

use App\Models\Exam;
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

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'category' => ['required'],
        ]);

        Exam::create($formFields);

        return redirect('/exams')->with('message', 'Exam successfully created');
    }

    public function show(Exam $exam): View
    {
        return view('exam.show', ['exam' => $exam]);
    }

    public function edit(Exam $exam): View
    {
        return view('exam.edit', ['exam' => $exam]);
    }

    public function update(Request $request, Exam $exam)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'category' => ['required'],
        ]);

        $exam->update($formFields);

        return back()->with('message', 'Exam updated successfully!');
    }

    public function destroy(Exam $exam) {
        $exam->delete();
        return redirect('/exams')->with('message','Deleted successfully');
    }
}
