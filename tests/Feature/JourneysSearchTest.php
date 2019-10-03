<?php

namespace Tests\Feature;

use App\Journey;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JourneysSearchTest extends TestCase
{
    use RefreshDatabase;

    protected $search_path = '/trajets/rechercher';

    /** @test */
    public function users_can_search_for_journeys()
    {
        factory(Journey::class)->create();

        $this->get($this->search_path)
            ->assertStatus(200)
            ->assertSee('Trouver un trajet');
    }

    /** @test */
    public function search_results_contain_expected_journeys ()
    {
        $journey = factory(Journey::class)->create([
            'departure' => 'Foo',
            'arrival' => 'Bar'
        ]);

        $journey = factory(Journey::class)->create([
            'departure' => 'Foo',
        ]);

        $journey = factory(Journey::class)->create([
            'arrival' => 'Bar'
        ]);

        $search_parameters = [
            'departure' => 'Foo',
            'arrival' => 'Bar'
        ];

        $this->post($this->search_path, $search_parameters);

        $this->assertEquals(3, Journey::count());
    }

    /** @test */
    public function full_journeys_do_not_appear_in_the_search_results ()
    {
        factory(Journey::class)->create(['departure' => 'test_departure']);

        $this->post('trajets/rechercher', ['departure' => 'test_departure'])
            ->assertSee('test_departure');

        Journey::find(1)->update(['seats' => 0]);

        $this->post('trajets/rechercher', ['departure' => 'test_departure'])
            ->assertDontSee('test_departure');
    }
}
