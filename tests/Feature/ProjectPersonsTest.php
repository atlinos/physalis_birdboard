<?php

namespace Tests\Feature;

use App\Person;
use Facades\Tests\Setup\ProjectFactory;
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
        $project = ProjectFactory::create();

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
    public function only_the_owner_of_a_project_may_update_a_person()
    {
        $this->signIn();

        $project = ProjectFactory::withPersons(1)->create();

        $this->patch($project->persons[0]->path(), $attributes = ['name' => 'Changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('people', $attributes);
    }

    /** @test */
    function a_person_can_be_updated()
    {
        $project = ProjectFactory::withPersons(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->persons[0]->path(), [
                'name' => 'Changed',
                'firstname' => 'Changed'
            ]);

        $this->assertDatabaseHas('people', [
            'name' => 'Changed',
            'firstname' => 'Changed'
        ]);
    }

    /** @test */
    function a_user_can_update_a_persons_notes()
    {
        $project = ProjectFactory::withPersons(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->persons[0]->path(), ['notes' => 'Changed']);

        $this->assertDatabaseHas('people', ['notes' => 'Changed']);
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
        $project = ProjectFactory::withPersons(1)->create();

        $this->actingAs($project->owner)
            ->delete($project->persons[0]->path())
            ->assertRedirect($project->path());

        $this->assertDatabaseMissing('people', $project->persons[0]->only('id'));
    }

    /** @test */
    public function a_person_requires_a_name()
    {
        $project = ProjectFactory::create();

        $attributes = factory('App\Person')->raw(['name' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/persons', $attributes)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_person_requires_a_firstname()
    {
        $project = ProjectFactory::withPersons(1)->create();

        $attributes = factory('App\Person')->raw(['firstname' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/persons', $attributes)
            ->assertSessionHasErrors('firstname');
    }
}
