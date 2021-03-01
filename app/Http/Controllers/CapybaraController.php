<?php

namespace App\Http\Controllers;

use App\Http\Resources\CapybaraResource;
use App\Models\Capybara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CapybaraController extends Controller
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
            'name' => 'required|unique:capybaras|max:255',
            'color' => 'required|max:255',
            'size' => 'required|max:255'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error'])
                ->setStatusCode(422);
        }

        $capybara = Capybara::create($data);

        return response([
            'capybara' => new CapybaraResource($capybara),
            'message' => 'Capybara created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Capybara  $capybara
     * @return \Illuminate\Http\Response
     */
    public function show(Capybara $capybara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Capybara  $capybara
     * @return \Illuminate\Http\Response
     */
    public function edit(Capybara $capybara)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Capybara  $capybara
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Capybara $capybara)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Capybara  $capybara
     * @return \Illuminate\Http\Response
     */
    public function destroy(Capybara $capybara)
    {
        //
    }
}
