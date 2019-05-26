<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function show(Project $project)
    {
        $this->authorize('manage', $project);

        return view('projects.show', compact('project'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'nullable',
            'notes' => 'min:3'
        ], [
            'title.required' => 'Le titre de la généalogie est obligatoire'
        ]);

        $project = auth()->user()->projects()->create($attributes);

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function update(Project $project)
    {
        $this->authorize('manage', $project);

        if (! request()->has('notes')) {
            $attributes = request()->validate([
                'title' => 'required',
                'description' => 'nullable'
            ], [
                'title.required' => 'Le titre de la généalogie est obligatoire'
            ]);
        } else {
            $attributes = request()->validate([
                'notes' => 'min:3'
            ], [
                'notes.min' => 'Les notes doivent au moins faire 3 caractères.'
            ]);
        }

        $project->update($attributes);

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }
}
