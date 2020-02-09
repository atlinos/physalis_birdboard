<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Person;
use App\Project;
use Illuminate\Http\Request;

class ProjectPeopleController extends Controller
{
    public function index(Project $project)
    {
        return $project->lastPeople;
    }

    public function store(PersonRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $person = $project->addPerson($request->all());

        if (request()->wantsJson()) {
            return ['message' => $person->path()];
        }

        return redirect($person->path());
    }

    public function show(Project $project, Person $person)
    {
        $this->authorize('update', $person);

        return view('people.show', compact('project', 'person'));
    }

    public function update(Project $project, Person $person, PersonRequest $request)
    {
        $this->authorize('update', $person);

        $person->update($request->all());

        if ($request->wantsJson()) {
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
