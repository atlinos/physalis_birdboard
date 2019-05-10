<?php

namespace Tests\Feature;

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

        $this->post($project->path() . '/persons', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['name'])
            ->assertSee($attributes['firstname']);
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
