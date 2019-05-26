<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function persons()
    {
        return $this->hasMany(Person::class);
    }

    public function lastPersons()
    {
        return $this->persons()->latest()->limit(25);
    }

    public function addPerson($attributes)
    {
        return $this->persons()->create($attributes);
    }
}
