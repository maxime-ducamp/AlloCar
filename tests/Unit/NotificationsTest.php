<?php

namespace Tests\Feature;

use App\Booking;
use App\Notifications\BookingApprovedNotification;
use App\Notifications\BookingDeniedNotification;
use App\Notifications\BookingRequestNotification;
use App\Notifications\JourneyCompletedNotification;
use App\Notifications\JourneyDeletedNotification;
use App\Notifications\PrivateMessageReceivedNotification;
use App\Notifications\RoleGrantedNotification;
use App\Notifications\RoleRemovedNotification;
use App\Notifications\UserCreatedNotification;
use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();
    }

    /** @test */
    public function notification_sent_when_booking_requested_on_user_s_journeys()
    {
        Notification::fake();

        $journey = $this->createJourney();

        factory(Booking::class)->create(['journey_id' => $journey->id]);

        Notification::assertSentTo(
            $journey->driver,
            BookingRequestNotification::class
        );
    }

    /** @test */
    public function notification_sent_when_journey_is_deleted_and_user_had_booked_it()
    {
        Notification::fake();

        $journey = $this->createJourney();

        $booking = factory(Booking::class)->create(['journey_id' => $journey->id]);

        $journey->delete();

        $this->assertEquals(0, Booking::count());

        Notification::assertSentTo(
            $booking->user,
            JourneyDeletedNotification::class
        );
    }

    /** @test */
    public function notification_sent_when_driver_accepts_a_booking()
    {
        Notification::fake();

        $journey = $this->createJourney();

        $booking = factory(Booking::class)->create(['journey_id' => $journey->id]);

        $this->actingAs($journey->driver)->post("/trajets/$journey->id/reservations/$booking->id/accepter");

        $this->assertEquals(1, Booking::count());

        Notification::assertSentTo(
            $booking->user,
            BookingApprovedNotification::class
        );
    }

    /** @test */
    public function notification_sent_when_driver_denies_a_booking()
    {
        Notification::fake();

        $journey = $this->createJourney();

        $booking = factory(Booking::class)->create(['journey_id' => $journey->id]);

        $this->actingAs($journey->driver)->post("/trajets/$journey->id/reservations/$booking->id/refuser");

        $this->assertEquals(1, Booking::count());

        Notification::assertSentTo(
            $booking->user,
            BookingDeniedNotification::class
        );
    }

    /** @test */
    public function notification_sent_when_a_user_received_a_private_message ()
    {
        Notification::fake();

        $sender = factory(User::class)->create();
        $receiver = factory(User::class)->create();

        $sender->sendMessageTo($receiver, 'test_subject', 'test_body');

        Notification::assertSentTo(
            $receiver,
            PrivateMessageReceivedNotification::class
        );
    }

    /** @test */
    public function notification_sent_when_user_is_assigned_a_role ()
    {
        Notification::fake();

        $super_admin = factory('App\User')->create()->addRole('super_admin');
        $target = factory('App\User')->create();

        $this->actingAs($super_admin)->post('/admin/roles/'. $target->name . '/assigner-un-role', ['user_role' => 'moderator']);

        Notification::assertSentTo(
            $target,
            RoleGrantedNotification::class
        );
    }

    /** @test */
    public function notification_sent_when_role_is_taken_back ()
    {
        Notification::fake();

        $super_admin = factory('App\User')->create()->addRole('super_admin');
        $target = factory('App\User')->create(['name' => 'target'])->addRole('moderator');

        $this->actingAs($super_admin)->post('/admin/roles/target/retirer-un-role', ['user_role' => 'moderator']);

        Notification::assertSentTo(
            $target,
            RoleRemovedNotification::class
        );
    }
}
