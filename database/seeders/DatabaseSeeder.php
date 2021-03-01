<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        collect(Location::ACCEPTABLE_LOCATIONS)->each(function($locationName){
           Location::factory()->create([
              'name' => $locationName
           ]);
        });
    }
}
