<?php

namespace App\Http\Controllers;

use App\Models\FilterTaxonomie;
use App\Http\Requests\StoreFilterTaxonomieRequest;
use App\Http\Requests\UpdateFilterTaxonomieRequest;

class FilterTaxonomieController extends Controller
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
     * @param  \App\Http\Requests\StoreFilterTaxonomieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFilterTaxonomieRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FilterTaxonomie  $filterTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function show(FilterTaxonomie $filterTaxonomie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FilterTaxonomie  $filterTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function edit(FilterTaxonomie $filterTaxonomie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFilterTaxonomieRequest  $request
     * @param  \App\Models\FilterTaxonomie  $filterTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFilterTaxonomieRequest $request, FilterTaxonomie $filterTaxonomie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FilterTaxonomie  $filterTaxonomie
     * @return \Illuminate\Http\Response
     */
    public function destroy(FilterTaxonomie $filterTaxonomie)
    {
        //
    }
}
