<?php

namespace App\Http\Controllers;

use App\Person;
use App\Project;
use Illuminate\Http\Request;

class ProjectPersonsController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('manage', $project);

        request()->validate([
            'name' => 'required',
            'firstname' => 'required'
        ], [
            'name.required' => 'Le nom est obligatoire',
            'firstname.required' => 'Le prénom est obligatoire',
        ]);

        $person = $project->addPerson(request()->all());

        if (request()->wantsJson()) {
            return ['message' => $person->path()];
        }

        return redirect($person->path());
    }

    public function show(Project $project, Person $person)
    {
        return view('persons.show', compact('project', 'person'));
    }

    public function update(Project $project, Person $person)
    {
        $this->authorize('manage', $person);

        if (! request()->has('notes')) {
            request()->validate([
                'name' => 'required',
                'firstname' => 'required'
            ], [
                'name.required' => 'Le nom est obligatoire',
                'firstname.required' => 'Le prénom est obligatoire',
            ]);
        } else {
            request()->validate([
                'notes' => 'min:3'
            ], [
                'notes.min' => 'Les notes doivent au moins faire 3 caractères.'
            ]);
        }

        $person->update(request()->all());

        if (request()->wantsJson()) {
            return ['message' => $person->path()];
        }

        return redirect($person->path());
    }

    public function destroy(Project $project, Person $person)
    {
        $this->authorize('manage', $person);

        $person->delete();

        return redirect($project->path());
    }
}
