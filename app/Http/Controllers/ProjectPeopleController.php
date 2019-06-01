<?php

namespace App\Http\Controllers;

use App\Person;
use App\Project;
use Illuminate\Http\Request;

class ProjectPeopleController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

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
        $this->authorize('update', $person);

        return view('persons.show', compact('project', 'person'));
    }

    public function update(Project $project, Person $person)
    {
        $this->authorize('update', $person);

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
        $this->authorize('update', $person);

        $person->delete();

        foreach ($person->activity as $activity) {
            if ($activity->description !== 'deleted_person') {
                $activity->delete();
            }
        }

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }
}
