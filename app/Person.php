<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $touches = ['project'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($person) {
            $person->project->increment('people_count');
        });

        static::deleting(function ($person) {
            $person->project->decrement('people_count');
        });
    }

    public function path()
    {
        return '/projects/' . $this->project_id . '/persons/' . $this->id;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function completeName()
    {
        return $this->name . ' ' . $this->firstname;
    }
}
