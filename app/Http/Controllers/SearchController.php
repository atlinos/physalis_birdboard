<?php

namespace App\Http\Controllers;

use App\Person;
use App\Project;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Project $project)
    {
        $this->authorize('update', $project);

        if (request()->expectsJson()) {
            return ! empty(request('q')) ? $project->search(request('q')) : null;
        }
    }
}
