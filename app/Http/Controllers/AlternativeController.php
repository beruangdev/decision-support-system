<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Http\Requests\StoreAlternativeRequest;
use App\Http\Requests\UpdateAlternativeRequest;
use App\Models\AlternativeTaxonomie;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("pages.alternative.index");
    }

    public function list()
    {
        $data = Alternative::where("user_id", Auth::id())->with(["alternative_taxonomies"])->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('taxonomies', function ($alternative) {
                return view("pages.alternative.components.table-button-taxonomies", compact("alternative"));
            })
            ->addColumn('action', function ($alternative) {
                return view("pages.alternative.components.table-button-action", compact("alternative"));
            })
            ->rawColumns(['action'])
            ->make(true);
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
     * @param  \App\Http\Requests\StoreAlternativeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlternativeRequest $requests)
    {
        $requests = $requests->all();

        $alternatives = [];
        foreach ($requests as $request) {
            $taxonomie_strings = [];
            foreach ($request["taxonomies"] as $req_taxonomy) {
                $key = Str::slug($req_taxonomy['key']);
                $value = Str::slug($req_taxonomy['value']);
                array_push($taxonomie_strings, "{$key}={$value}");
            }
            $taxonomie_strings = join(",", $taxonomie_strings);

            $alternative = new Alternative();
            $alternative->name = $request["name"];
            $alternative->description = $request["description"];
            $alternative->taxonomie_strings = $taxonomie_strings;
            $alternative->user_id = Auth::id();
            $alternative->save();
            $taxonomies = [];
            foreach ($request["taxonomies"] as $req_taxonomy) {
                $taxonomy = new AlternativeTaxonomie();
                $taxonomy->key = $req_taxonomy["key"];
                $taxonomy->key_slug = Str::slug($req_taxonomy["key"]);
                $taxonomy->value = $req_taxonomy["value"];
                $taxonomy->value_slug = Str::slug($req_taxonomy["value"]);
                $taxonomy->alternative_id = $alternative->id;
                $taxonomy->user_id = Auth::id();
                $taxonomy->save();
                array_push($taxonomies, $taxonomy);
            }

            $alternative["taxonomies"] = $taxonomies;
            array_push($alternatives, $alternative);
        }
        return response()->json(compact("alternative", "taxonomies"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alternative  $alternative
     * @return \Illuminate\Http\Response
     */
    public function show(Alternative $alternative)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alternative  $alternative
     * @return \Illuminate\Http\Response
     */
    public function edit(Alternative $alternative)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlternativeRequest  $request
     * @param  \App\Models\Alternative  $alternative
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlternativeRequest $request, Alternative $alternative)
    {
        $taxonomie_strings = [];
        foreach ($request->taxonomies as $req_taxonomy) {
            $key = Str::slug($req_taxonomy['key']);
            $value = Str::slug($req_taxonomy['value']);
            array_push($taxonomie_strings, "{$key}={$value}");
        }
        $taxonomie_strings = join(",", $taxonomie_strings);
        
        $alternative->name = $request->name;
        $alternative->description = $request->description;
        $alternative->taxonomie_strings = $taxonomie_strings;
        $alternative->save();

        $taxonomies = [];
        AlternativeTaxonomie::where("alternative_id", $alternative->id)->delete();
        foreach ($request->taxonomies as $req_taxonomy) {
            $taxonomy = new AlternativeTaxonomie();
            $taxonomy->key = $req_taxonomy["key"];
            $taxonomy->key_slug = Str::slug($req_taxonomy["key"]);
            $taxonomy->value = $req_taxonomy["value"];
            $taxonomy->value_slug = Str::slug($req_taxonomy["value"]);
            $taxonomy->alternative_id = $alternative->id;
            $taxonomy->user_id = Auth::id();
            $taxonomy->save();
            array_push($taxonomies, $taxonomy);
        }

        return response()->json(compact("alternative", "taxonomies"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alternative  $alternative
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alternative $alternative)
    {
        $alternative->delete();
        return response()->json(true);
    }
}
