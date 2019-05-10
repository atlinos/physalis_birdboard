<?php

namespace App\Http\Controllers;

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

        $project->addPerson(request()->all());

        return redirect($project->path());
    }
}
