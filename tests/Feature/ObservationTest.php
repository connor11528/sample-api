<?php

namespace Tests\Feature;

use App\Models\Capybara;
use App\Models\Location;
use App\Models\Observation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ObservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_observation_test()
    {
        Location::factory()->create([
            'name' => 'San Francisco',
        ]);

        Capybara::factory()->create([
            'name' => 'Hydrochoerus hydrochaeris'
        ]);

        $observationData = [
            'capybara_name' => 'Hydrochoerus hydrochaeris',
            'sighting_date' => '2021-03-01 01:18:34',
            'location_name' => 'San Francisco',
            'wearing_hat' => false
        ];

        $this->json('POST', 'api/observations', $observationData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'observation' => [
                    'id' ,
                    'capybara_id',
                    'sighting_date',
                    'location_id',
                    'created_at',
                    'updated_at',
                ],
                "message"
            ]);
    }

    /** @test */
    public function test_one_capybara_per_location_per_day()
    {
        $location = Location::factory()->create([
            'name' => 'San Francisco',
        ]);

        $capybara = Capybara::factory()->create([
            'name' => 'Hydrochoerus hydrochaeris'
        ]);

        $observation1 = Observation::factory()->create([
            'location_id' => $location->id,
            'capybara_id' => $capybara->id,
            'sighting_date' => now()->toDateTimeString()
        ]);

        $observationData = [
            'capybara_name' => $capybara->name,
            'sighting_date' => now()->toDateTimeString(),
            'location_name' => $location->name,
            'wearing_hat' => false
        ];

        $this->json('POST', 'api/observations', $observationData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_cannot_add_observation_for_unsupported_location()
    {
        $capybara = Capybara::factory()->create([
            'name' => 'Hydrochoerus hydrochaeris'
        ]);

        // add all supported locations
        collect(Location::ACCEPTABLE_LOCATIONS)->each(function($locationName){
            Location::factory()->create([
                'name' => $locationName
            ]);
        });

        $observationData = [
            'capybara_name' => $capybara->name,
            'sighting_date' => now()->toDateTimeString(),
            'location_name' => 'Los Angeles',
            'wearing_hat' => false
        ];

        $this->json('POST', 'api/observations', $observationData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_can_add_observation_for_supported_location()
    {
        $capybara = Capybara::factory()->create([
            'name' => 'Hydrochoerus hydrochaeris'
        ]);

        // add all supported locations
        collect(Location::ACCEPTABLE_LOCATIONS)->each(function($locationName){
            Location::factory()->create([
                'name' => $locationName
            ]);
        });

        $observationData = [
            'capybara_name' => $capybara->name,
            'sighting_date' => now()->toDateTimeString(),
            'location_name' => 'San Francisco',
            'wearing_hat' => true
        ];

        $this->json('POST', 'api/observations', $observationData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'observation' => [
                    'id' ,
                    'capybara_id',
                    'sighting_date',
                    'location_id',
                    'created_at',
                    'updated_at',
                ],
                "message"
            ]);
    }


}
