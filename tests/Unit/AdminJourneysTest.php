<?php

namespace Tests\Unit;

use App\Journey;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminJourneysTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $journey;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();

        $this->admin = $this->createAdmin();
        $this->journey = factory('App\Journey')->create();
    }

    /** @test */
    public function admin_users_can_delete_journeys ()
    {
        $this->actingAs($this->admin)->delete('/admin/trajets/1');

        $this->assertEquals(0, Journey::count());
    }

    /** @test */
    public function admin_users_can_update_journeys ()
    {
        $this->actingAs($this->admin)->put('/admin/trajets/1', [
            'departure' => 'updated_departure'
        ]);

        $this->assertEquals('updated_departure', Journey::first()->departure);
    }
}
