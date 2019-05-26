<?php

namespace Tests\Setup;

use App\Person;
use App\Project;
use App\User;

class ProjectFactory
{
    protected $personsCount = 0;

    protected $user;

    public function withPersons($count)
    {
        $this->personsCount = $count;

        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->user ?: factory(User::class)
        ]);

        factory(Person::class, $this->personsCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}
