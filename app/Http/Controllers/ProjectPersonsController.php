<?php

namespace App\Http\Controllers;

use App\Person;
use App\Project;
use Illuminate\Http\Request;

class ProjectPersonsController extends Controller
{
    public function store(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        request()->validate([
            'name' => 'required',
            'firstname' => 'required'
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
}
