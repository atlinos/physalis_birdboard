<?php

namespace App\Policies;

use App\Person;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Person $person)
    {
        return $user->is($person->project->owner) || $person->project->members->contains($user);
    }
}
