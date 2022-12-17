<?php

namespace App\Http\Controllers;

use App\Models\Algorithm;
use App\Http\Requests\StoreAlgorithmRequest;
use App\Http\Requests\UpdateAlgorithmRequest;

class AlgorithmController extends Controller
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
     * @param  \App\Http\Requests\StoreAlgorithmRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlgorithmRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Algorithm  $algorithm
     * @return \Illuminate\Http\Response
     */
    public function show(Algorithm $algorithm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Algorithm  $algorithm
     * @return \Illuminate\Http\Response
     */
    public function edit(Algorithm $algorithm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlgorithmRequest  $request
     * @param  \App\Models\Algorithm  $algorithm
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlgorithmRequest $request, Algorithm $algorithm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Algorithm  $algorithm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Algorithm $algorithm)
    {
        //
    }
}
