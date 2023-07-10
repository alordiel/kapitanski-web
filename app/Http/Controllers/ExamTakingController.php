<?php

namespace App\Http\Controllers;

use App\Models\ExamTaking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamTakingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('examTaking.index', [
            'examTakings' => ExamTaking::all()
        ]);
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
    public function show(ExamTaking $examTaking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamTaking $examTaking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamTaking $examTaking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamTaking $examTaking)
    {
        //
    }
}
