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
            'questionCategories' => QuestionCategory::all()
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
            'slug' => 'required',
        ]);

        QuestionCategory::create($formFields);

        return redirect(route('questionCategory.manage'))->with('message', 'Category successfully created');
    }

    public function edit(QuestionCategory $questionCategory): View
    {
        return view('questionCategory.edit', ['questionCategory' => $questionCategory]);
    }

    public function update(Request $request, QuestionCategory $questionCategory): RedirectResponse
    {
        $formFields = $request->validate([
            'name' => 'required',
        ]);

        $questionCategory->update($formFields);

        return back()->with('message', 'Category updated successfully!');
    }

    public function destroy(QuestionCategory $questionCategory): RedirectResponse
    {
        $questionCategory->delete();
        return redirect(route('questionCategory.manage'))->with('message', 'Deleted successfully');
    }
}
