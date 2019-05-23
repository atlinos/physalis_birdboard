<?php

namespace Tests\Unit;

use App\Person;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $person = factory(Person::class)->create();

        $this->assertEquals(
            '/projects/' . $person->project_id . '/persons/' . $person->id,
            $person->path()
        );
    }
    
    /** @test */
    public function it_belongs_to_a_project()
    {
        $person = factory('App\Person')->create();

        $this->assertInstanceOf(Project::class, $person->project);
    }

    /** @test */
    public function it_has_a_complete_name()
    {
        $person = factory(Person::class)->create();

        $this->assertEquals(
            $person->name . ' ' . $person->firstname,
            $person->completeName()
        );
    }
}
