<?php

namespace Tests\Feature;

use App\Http\Requests\CreateJourneyRequest;
use App\Journey;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JourneysTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();
    }

    /** @test */
    public function guests_cannot_create_journeys()
    {
        $journey = factory(Journey::class)->raw();

        $this->post('/trajets', $journey)
            ->assertStatus(302)
            ->assertRedirect('/connection');
        $this->assertDatabaseMissing('journeys', $journey);
    }

    /** @test */
    public function all_users_can_view_a_journey_s_page()
    {
        $journey = $this->createJourney();

        $this->get('/trajets/1')
            ->assertStatus(200)
            ->assertSee($journey->driver->name);
    }

    /** @test */
    public function only_authorized_users_can_see_the_journey_create_page()
    {
        /** Guest user */
        $this->get('/trajets/nouveau')
            ->assertStatus(302)
            ->assertRedirect('/connection');

        /** Authenticated User */
        $this->login()->get('/trajets/nouveau')
            ->assertStatus(200);
    }

    /** @test */
    public function only_authorized_users_can_see_the_journey_edit_page()
    {
        $journey = $this->createJourney();

        /** Guest user */
        $this->get('/trajets/1/modifier')
            ->assertStatus(302)
            ->assertRedirect('/connection');

        $this->login(factory(User::class)->create());

        /** Authenticated non authorized user */
        $this->get('/trajets/1/modifier')
            ->assertStatus(403);

        /** Authenticated authorized user */
        $this->actingAs($journey->driver)
            ->get('/trajets/1/modifier')
            ->assertStatus(200)
            ->assertSee('Modifier votre trajet');
    }

    /** @test */
    public function drivers_can_update_their_journeys()
    {
        $this->withoutExceptionHandling();
        $journey = $this->createJourney();

        $data = $journey->toArray();
        $data['departure'] = 'updated_departure';

        $this->actingAs($journey->driver)->put('/trajets/1', $data);

        $this->assertDatabaseHas('journeys', ['departure' => 'updated_departure']);
    }

    /** @test */
    public function only_authorized_users_can_update_journeys()
    {
        $this->createJourney();

        /** Guest user */
        $this->put('/trajets/1', ['departure' => 'unauthorized']);
        $this->assertDatabaseMissing('journeys', ['departure' => 'unauthorized']);

        /** Authenticated unauthorized user */
        $this->login();
        $this->put('/trajets/1', ['departure' => 'unauthorized'])
            ->assertStatus(302);

        $this->assertDatabaseMissing('journeys', ['departure' => 'unauthorized']);
    }

    /** @test */
    public function drivers_can_delete_their_journeys()
    {
        $journey = $this->createJourney();
        $this->actingAs($journey->driver)->delete('/trajets/1');

        $this->assertDatabaseMissing('journeys', ['departure' => $journey->departure]);
    }

    /** @test */
    public function unauthorized_users_cannot_delete_journeys()
    {
        $journey = $this->createJourney();

        $this->login();

        $this->delete('/trajets/1')
            ->assertStatus(403);

        $this->assertDatabaseHas('journeys', ['departure' => $journey->departure]);

        $this->logout();

        $this->delete('/trajets/1')
            ->assertStatus(302);
    }
}
