<?php

namespace Tests\Feature;

use App\Person;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_project', $activity->description);

            $this->assertNull($activity->changes);
        });
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();
        $originalTitle = $project->title;

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'changed']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test */
    public function creating_a_new_person()
    {
        $project = ProjectFactory::create();

        $project->addPerson(['name' => 'Doe', 'firstname' => 'John']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_person', $activity->description);
            $this->assertInstanceOf(Person::class, $activity->subject);
            $this->assertEquals('Doe', $activity->subject->name);
        });
    }

    /** @test */
    public function updating_a_person()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::withPersons(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->people[0]->path(), [
                'name' => 'changed',
                'firstname' => 'changed'
            ]);

        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('updated_person', $activity->description);
            $this->assertInstanceOf(Person::class, $activity->subject);
        });
    }

    /** @test */
    public function deleting_a_person()
    {
        $project = ProjectFactory::withPersons(1)->create();

        $project->people[0]->delete();

        $this->assertCount(3, $project->activity);

        $this->assertEquals('deleted_person', $project->activity->last()->description);
    }
}
