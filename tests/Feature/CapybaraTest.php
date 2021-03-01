<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CapybaraTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_capybara_test()
    {
        $capybaraData = [
            "name" => "Hydrochoerus hydrochaeris",
            "color" => "Brown",
            "size" => "Medium",
        ];

        $this->json('POST', 'api/capybaras', $capybaraData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "capybara" => [
                    'id',
                    'name',
                    'color',
                    'size',
                    'created_at',
                    'updated_at'
                ],
                "message"
            ]);
    }
}
