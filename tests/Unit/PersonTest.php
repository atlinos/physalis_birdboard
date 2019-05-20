<?php

namespace Tests\Unit;

use App\Person;
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
    public function it_has_a_complete_name()
    {
        $person = factory(Person::class)->create();

        $this->assertEquals(
            $person->name . ' ' . $person->firstname,
            $person->completeName()
        );
    }
}
