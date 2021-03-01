<?php

namespace Tests\Feature;

use App\Models\Capybara;
use App\Models\Location;
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
}
