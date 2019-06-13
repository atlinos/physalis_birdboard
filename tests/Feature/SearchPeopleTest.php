<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchPeopleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_people()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/persons', [
                'name' => 'Foobar People', 'firstname' => 'First People'
            ]);

        $results = $this->getJson($project->path() . '/search?q=Foobar')->json();

        $this->assertCount(1, $results);

        $results = $this->getJson($project->path() . '/search?q=First')->json();

        $this->assertCount(1, $results);
    }

    /** @test */
    public function a_user_can_only_find_people_that_are_in_their_project()
    {
        $john =factory('App\User')->create();
        $sally =factory('App\User')->create();

        $project = ProjectFactory::ownedBy($sally)->create();

        $this->actingAs($sally)
            ->post($project->path() . '/persons', [
                'name' => 'Foobar People', 'firstname' => 'First People'
            ]);

        $this->actingAs($john)
            ->getJson($project->path() . '/search?q=Foobar')
            ->assertStatus(403);

        $results = $this->actingAs($sally)
            ->getJson($project->path() . '/search?q=Foobar')->json();

        $this->assertCount(1, $results);
    }
}
