<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Subjects', [
            'subjects' => Subject::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $subject = Subject::create([
            'user_id' => auth()->guard()->user()->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('subjects')
            ->with('success', 'Subject added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject): void
    {
        //
    }
}
