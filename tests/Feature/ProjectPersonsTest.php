<?php

namespace Tests\Feature;

use App\Person;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectPersonsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/persons')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_persons()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $attributes = [
            'name' => 'Doe',
            'firstname' => 'John'
        ];

        $this->post($project->path() . '/persons', $attributes)
            ->assertStatus(403);

        $this->assertDatabaseMissing('people', $attributes);
    }

    /** @test */
    public function a_project_can_have_persons()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $attributes = [
            'name' => 'Doe',
            'firstname' => 'John'
        ];

        $response = $this->post($project->path() . '/persons', $attributes);
        
        $person = Person::first();

        $response->assertRedirect($person->path())
            ->assertSee($attributes['name'])
            ->assertSee($attributes['firstname']);
    }

    /** @test */
    function a_person_can_be_updated()
    {
        $this->signIn();

        $person = factory('App\Person')->create();

        $this->patch($person->path(), $attributes = ['name' => 'Changed']);

        $this->assertDatabaseHas('people', $attributes);
    }

    /** @test */
    function a_user_can_update_a_persons_notes()
    {
        $this->signIn();

        $person = factory('App\Person')->create();

        $this->patch($person->path(), $attributes = ['notes' => 'Changed']);

        $this->assertDatabaseHas('people', $attributes);
    }

    /** @test */
    public function a_person_requires_a_name()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $attributes = factory('App\Person')->raw(['name' => '']);

        $this->post($project->path() . '/persons', $attributes)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_person_requires_a_firstname()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $attributes = factory('App\Person')->raw(['firstname' => '']);

        $this->post($project->path() . '/persons', $attributes)
            ->assertSessionHasErrors('firstname');
    }
}
