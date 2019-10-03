<?php

namespace Tests\Unit;

use App\Booking;
use App\Journey;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JourneysUnitTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();
    }

    /** @test */
    public function journeys_can_be_deleted()
    {
        $journey = $this->createJourney();

        $this->actingAs($journey->driver)->delete('/trajets/' . $journey->id);

        $this->assertEquals(0, Journey::count());
    }

    /** @test */
    public function journeys_can_be_updated()
    {
        $journey = $this->createJourney();

        $data = $journey->toArray();
        $data['departure'] = 'updated_departure';

        $this->actingAs($journey->driver)->put('/trajets/1', $data);

        $this->assertEquals('updated_departure', Journey::first()->departure);
    }

    /** @test */
    public function journeys_can_be_marked_as_completed()
    {
        $journey = $this->createJourney();

        $this->actingAs($journey->driver)->post('/trajets/1/complete');

        $this->assertNotNull($journey->fresh()->completed_at);
    }

    /** @test */
    public function marking_journeys_as_completed_deletes_journeys_bookings()
    {
        $journey = $this->createJourney();

        $booking = factory(Booking::class)->create(['journey_id' => $journey->id]);

        $this->assertEquals(1, Booking::count());

        $journey->approveBooking($booking);

        $journey->markAsCompleted();

        $this->assertEquals(0, Booking::count());
    }

    /** @test */
    public function users_can_edit_their_preferences_for_pets_and_smoking()
    {
        $journey = factory('App\Journey')->create(['allows_pets' => 0, 'allows_smoking' => 1]);
        $this->assertEquals(0, $journey->allows_pets);
        $this->assertEquals(1, $journey->allows_smoking);

        $data = $journey->toArray();
        $data['allows_pets'] = 1;
        $data['allows_smoking'] = 0;

        $this->actingAs($journey->driver)->put('/trajets/1', $data);

        $this->assertEquals(1, $journey->fresh()->allows_pets);
        $this->assertEquals(0, $journey->fresh()->allows_smoking);
    }

    /** @test */
    public function journeys_can_return_a_collection_of_their_participants()
    {
        $journey = factory(Journey::class)->create();
        factory(Booking::class, 3)->create(['journey_id' => $journey->id]);

        /** The bookings haven't been approved yet, the collection should be empty*/
        $this->assertEquals(0, $journey->participants()->count());

        foreach($journey->bookings as $booking) {
            $journey->approveBooking($booking);
        }

        /** All bookings have been approved, the collection should now contain 3 users */
        $this->assertEquals(3, $journey->fresh()->participants()->count());
        $this->assertInstanceOf(User::class, $journey->fresh()->participants()->first());
    }
}
