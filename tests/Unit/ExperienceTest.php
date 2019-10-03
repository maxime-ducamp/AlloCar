<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExperienceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_gain_experience()
    {
        $user = factory(User::class)->create();

        $user->increment('experience');

        $this->assertEquals(1, User::first()->experience);
    }

    /** @test */
    public function completing_a_journey_increases_a_user_s_experience()
    {
        $journey = $this->createJourney();

        $journey->markAsCompleted();

        $this->assertEquals(10, $journey->driver->experience);
    }
}
