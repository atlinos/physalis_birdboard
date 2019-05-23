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

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $attributes = [
            'name' => 'Doe',
            'firstname' => 'John'
        ];

        $response = $this->actingAs($project->owner)
            ->post($project->path() . '/persons', $attributes);
        
        $person = Person::first();

        $response->assertRedirect($person->path());

        $this->get($project->path())
            ->assertSee($attributes['name'])
            ->assertSee($attributes['firstname']);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_persons()
    {
        $this->signIn();

        $person = factory('App\Person')->create();

        $this->patch($person->path(), $attributes = ['name' => 'Changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('people', $attributes);
    }

    /** @test */
    function a_person_can_be_updated()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $person = factory('App\Person')->create(['project_id' => $project->id]);

        $this->patch($person->path(), $attributes = ['name' => 'Changed', 'firstname' => 'Changed']);

        $this->assertDatabaseHas('people', $attributes);
    }

    /** @test */
    function a_user_can_update_a_persons_notes()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $person = factory('App\Person')->create(['project_id' => $project->id]);

        $this->patch($person->path(), $attributes = ['notes' => 'Changed']);

        $this->assertDatabaseHas('people', $attributes);
    }

    /** @test */
    function unauthorized_users_cannot_delete_persons()
    {
        $person = factory('App\Person')->create();

        $this->delete($person->path())
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_delete_a_person()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $person = factory('App\Person')->create(['project_id' => $project->id]);

        $this->delete($person->path())
            ->assertRedirect($person->project->path());

        $this->assertDatabaseMissing('people', $person->only('id'));
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
