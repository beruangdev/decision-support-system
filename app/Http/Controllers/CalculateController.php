<?php

namespace App\Http\Controllers;

use App\Models\Calculate;
use App\Http\Requests\StoreCalculateRequest;
use App\Http\Requests\UpdateCalculateRequest;

class CalculateController extends Controller
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
     * @param  \App\Http\Requests\StoreCalculateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCalculateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calculate  $calculate
     * @return \Illuminate\Http\Response
     */
    public function show(Calculate $calculate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calculate  $calculate
     * @return \Illuminate\Http\Response
     */
    public function edit(Calculate $calculate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCalculateRequest  $request
     * @param  \App\Models\Calculate  $calculate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCalculateRequest $request, Calculate $calculate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calculate  $calculate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calculate $calculate)
    {
        //
    }
}
