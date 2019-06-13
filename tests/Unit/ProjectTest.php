<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_has_a_path()
    {
        $project = factory(Project::class)->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }
    
    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = factory(Project::class)->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }
    
    /** @test */
    public function it_can_add_a_person()
    {
        $project = factory(Project::class)->create();

        $project->addPerson(['name' => 'Doe', 'firstname' => 'John']);

        $this->assertCount(1, $project->people);
    }

    /** @test */
    public function it_can_invite_a_user()
    {
        $project = factory(Project::class)->create();

        $project->invite($user = factory('App\User')->create());

        $this->assertTrue($project->members->contains($user));
    }

    /** @test */
    public function it_can_search_for_its_people()
    {
        $project = factory(Project::class)->create();

        $personInProject1 = $project->addPerson(['name' => 'Doe', 'firstname' => 'John']);
        $personInProject2 = $project->addPerson(['name' => 'Doe Me', 'firstname' => 'Henry']);

        $personNotInProject = factory('App\Person')->create(['name' => 'Doe']);

        $results = $project->search('doe');

        $this->assertCount(2, $results);

        $this->assertEquals($results[0]->id, $personInProject1->id);
        $this->assertEquals($results[1]->id, $personInProject2->id);

        $this->assertNotEquals($results[0]->id, $personNotInProject->id);
    }
}
