<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $subjects = Subject::forCurrentUser()
            ->select('id', 'name', 'description', 'slug')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Subject/index', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $subject = new Subject;
        $subject->name = $validated['name'];
        $subject->description = $validated['description'];
        $subject->user_id = Auth::id();
        $subject->save();

        return Inertia::flash('success', 'Subject created successfully.')->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject): Response
    {
        Gate::authorize('view', $subject);

        return Inertia::render('Subject/show', [
            'subject' => $subject->only('id', 'name', 'description', 'slug'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject): RedirectResponse
    {
        Gate::authorize('update', $subject);
        $validated = $request->validated();
        $subject->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);
        Inertia::flash('success', 'Subject updated successfully.');

        return redirect()->route('subjects.show', $subject->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject): RedirectResponse
    {
        Gate::authorize('delete', $subject);
        $subject->delete();
        Inertia::flash('success', 'Subject deleted successfully.');

        return redirect()->route('subjects.index');
    }
}
