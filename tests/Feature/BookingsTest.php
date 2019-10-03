<?php

namespace Tests\Feature;

use App\User;
use App\Booking;
use App\Journey;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();
    }

    /** @test */
    public function registered_users_can_ask_drivers_for_journey_booking()
    {
        $this->createJourney();

        $user = factory(User::class)->create();

        $this->actingAs($user)->post('/trajets/1/reservations')
            ->assertRedirect('/trajets/1');

        $this->assertEquals(1, $user->bookings->count());
    }

    /** @test */
    public function created_bookings_have_a_true_pending_status()
    {
        $booking = factory(Booking::class)->create();

        $this->assertTrue($booking->pending);
    }

    /** @test */
    public function approval_or_denial_make_booking_lose_its_pending_status()
    {
        $booking = factory(Booking::class)->create();

        $driver = $booking->journey->driver;

        $this->actingAs($driver)->post('/trajets/1/reservations/1/accepter');

        $this->assertFalse($booking->fresh()->pending);
    }

    /** @test */
    public function journeys_drivers_can_approve_bookings()
    {
        $journey = factory(Journey::class)->create();
        $seats_before = $journey->seats;

        $booking = factory(Booking::class)->create(['journey_id' => $journey->id]);

        $journey->approveBooking($booking);
        $seats_after = $journey->seats;

        $this->assertEquals(($seats_before - 1), $seats_after);
    }

    /** @test */
    public function journeys_drivers_can_deny_bookings()
    {
        $journey = factory(Journey::class)->create();

        $booking = factory(Booking::class)->create(['journey_id' => $journey->id]);

        $journey->denyBooking($booking);

        $this->assertFalse($booking->fresh()->pending);
    }

    /** @test */
    public function bookings_can_tell_if_they_have_been_approved()
    {
        $journey = factory(Journey::class)->create();

        $booking = factory(Booking::class)->create(['journey_id' => $journey->id]);

        $journey->approveBooking($booking);

        $this->assertTrue($booking->fresh()->approved);
    }

    /** @test */
    public function bookings_can_tell_if_they_have_been_denied ()
    {
        $journey = factory(Journey::class)->create();

        $booking = factory(Booking::class)->create(['journey_id' => $journey->id]);

        $journey->denyBooking($booking);

        $this->assertFalse($booking->fresh()->approved);
    }

    /** @test */
    public function full_journeys_cannot_accept_any_more_bookings ()
    {
        $journey = factory(Journey::class)->create(['seats' => 1]);

        $first_booking = factory(Booking::class)->create(['journey_id' => $journey->id]);
        $journey->approveBooking($first_booking);

        $second_booking = factory(Booking::class)->create(['journey_id' => $journey->id]);

        /** The approveBooking method should return false since the number of seats is now at 0 */
        $this->assertFalse($journey->approveBooking($second_booking));

        /** The journey shouldn't be able to approve the second booking so we expect there to
         * still be only one booking registered for this Journey */
        $this->assertEquals(1, $journey->fresh()->bookings()->count());
    }
}
