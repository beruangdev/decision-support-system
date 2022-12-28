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

    public function list($project_id)
    {
        $data = Alternative::where("user_id", Auth::id())->where("project_id", $project_id)->with(["alternative_taxonomies"])->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($alternative) use ($project_id) {
                $label = $alternative->name;
                $attributes = collect([
                    "href" => route("alternative.show", ["project" => $project_id, "alternative" => $alternative->id])
                ]);
                return view("components.link", compact("label", "attributes"));
            })
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

    public function store(StoreAlternativeRequest $request)
    {
        $alternatives = [];
        foreach ($request->alternatives as $request_alternative) {
            $req_alternative = [
                "name" => $request_alternative["name"],
                "description" => $request_alternative["description"],
                "taxonomie_strings" => "",
                "user_id" => Auth::id(),
            ];
            array_push($alternatives, Alternative::create($req_alternative));
        }

        $taxonomies = [];
        foreach ($request->taxonomies as $index => $request_taxonomies) {
            $taxonomie_strings = [];
            $req_taxonomies = [];
            foreach ($request_taxonomies as $key => $request_taxonomy) {
                array_push($taxonomie_strings, Str::slug($request_taxonomy["key"]) . "=" . Str::slug($request_taxonomy["value"]));
                array_push($req_taxonomies, [
                    "key" => $request_taxonomy["key"],
                    "value" => $request_taxonomy["value"],
                    "key_slug" => Str::slug($request_taxonomy["key"]),
                    "value_slug" =>  Str::slug($request_taxonomy["value"]),
                    "alternative_id" => $alternatives[$index]->id,
                    "user_id" => Auth::id(),
                ]);
            }
            array_push($taxonomies, AlternativeTaxonomie::insert($req_taxonomies));

            $alternatives[$index]->taxonomie_strings = join(",", $taxonomie_strings);
            $alternatives[$index]->save();
        }
        return response()->json(compact("alternatives", "taxonomies"));
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
    public function destroy( $alternative_id)
    {
        return response()->json(Alternative::where("id", $alternative_id)->delete());
    }
}
