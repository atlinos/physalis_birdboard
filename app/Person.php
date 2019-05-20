<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/projects/' . $this->project_id . '/persons/' . $this->id;
    }

    public function completeName()
    {
        return $this->name . ' ' . $this->firstname;
    }
}
