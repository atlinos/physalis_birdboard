<?php

namespace App\Policies;

use App\Person;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Person $person)
    {
        return $user->is($person->project->owner);
    }
}
