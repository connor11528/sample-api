<?php

namespace App\Http\Controllers;

use App\Http\Resources\CapybaraResource;
use App\Http\Resources\ObservationResource;
use App\Models\Capybara;
use App\Models\Location;
use App\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'capybara_name' => 'required|exists:capybaras,name',
            'sighting_date' => 'required|date|before_or_equal:now', // cannot record sightings in the future
            'location_name' => 'required|exists:locations,name', // must be a location name that we have on our locations.name column
            'wearing_hat' => 'required|boolean'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $location = Location::firstWhere('name', $data['location_name']);
        $capybara = Capybara::firstWhere('name', $data['capybara_name']);

        $sightingDate = Carbon::parse($data['sighting_date']);

        // check that can't see capybara in same location on same day
        $existingObservation = Observation::whereDate('sighting_date', '=', $sightingDate->format('Y-m-d'))
            ->where([
                'location_id' => $location->id,
                'capybara_id' => $capybara->id
            ])
            ->get();

        if ($existingObservation->isNotEmpty()){
            return response([
                'error' => 'We have already recorded an observation of this Capybara in this location today',
            ])->setStatusCode(422);
        }

        $observation = Observation::create([
            'location_id' => $location->id,
            'capybara_id' => $capybara->id,
            'sighting_date' => $data['sighting_date'],
            'wearing_hat' => $data['wearing_hat']
        ]);

        return response([
            'observation' => new ObservationResource($observation),
            'message' => 'Observation created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function show(Observation $observation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function edit(Observation $observation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Observation $observation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Observation $observation)
    {
        //
    }
}
