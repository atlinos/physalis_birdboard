<?php

namespace App\Observers;

use App\Person;

class PersonObserver
{
    /**
     * Handle the person "created" event.
     *
     * @param  \App\Person  $person
     * @return void
     */
    public function created(Person $person)
    {
        $person->recordActivity('created_person');
    }

    /**
     * Handle the person "updated" event.
     *
     * @param  \App\Person  $person
     * @return void
     */
    public function updated(Person $person)
    {
        $person->recordActivity('updated_person');
    }

    /**
     * Handle the person "deleted" event.
     *
     * @param  \App\Person  $person
     * @return void
     */
    public function deleted(Person $person)
    {
        $person->recordActivity('deleted_person');
    }
}
