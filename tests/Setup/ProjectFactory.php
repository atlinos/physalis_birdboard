<?php

namespace Tests\Setup;

use App\Person;
use App\Project;
use App\User;

class ProjectFactory
{
    protected $peopleCount = 0;

    protected $user;

    public function withPeople($count)
    {
        $this->peopleCount = $count;

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

        factory(Person::class, $this->peopleCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}
