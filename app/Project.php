<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected static $recordableEvents = ['created', 'updated'];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function people()
    {
        return $this->hasMany(Person::class);
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }

    public function search($request)
    {
        return $this->people()
            ->where(\DB::raw('CONCAT(name," ",firstname)'), 'like', $request . '%')
            ->get();
    }

    public function lastPeople()
    {
        return $this->people()->latest()->limit(10);
    }

    public function addPerson($attributes)
    {
        return $this->people()->create($attributes);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest()->limit(10);
    }
}
