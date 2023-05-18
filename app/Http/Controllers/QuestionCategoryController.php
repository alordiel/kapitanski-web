<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionCategoryController extends Controller
{
    public function index(): View
    {
        return view('questionCategory.index', [
            'exams' => QuestionCategory::all()
        ]);
    }

    public function create(): View
    {
        return view('questionCategory.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $formFields = $request->validate([
            'name' => 'required',
        ]);

        QuestionCategory::create($formFields);

        return redirect('/admin/exams')->with('message', 'Exam successfully created');
    }

    public function show(QuestionCategory $questionCategory): View
    {
        return view('questionCategory.show', ['exam' => $questionCategory]);
    }

    public function questions(QuestionCategory $questionCategory): View
    {
        return view('questionCategory.questions', ['exam' => $questionCategory]);
    }

    public function edit(QuestionCategory $questionCategory): View
    {
        return view('questionCategory.edit', ['exam' => $questionCategory]);
    }

    public function update(Request $request, QuestionCategory $questionCategory): RedirectResponse
    {
        $formFields = $request->validate([
            'name' => 'required',
        ]);

        $questionCategory->update($formFields);

        return back()->with('message', 'Exam updated successfully!');
    }

    public function destroy(QuestionCategory $questionCategory): RedirectResponse
    {
        $questionCategory->delete();
        return redirect('/admin/exams')->with('message', 'Deleted successfully');
    }
}
