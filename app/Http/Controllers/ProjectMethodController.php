<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreProjectMethodRequest;
use App\Http\Requests\UpdateProjectMethodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\ProjectMethod;
use App\Models\Criteria;
use App\Models\CriteriaRasio;
use App\Models\Method;

class ProjectMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id)
    {
        return view("pages.project_method.index", compact("project_id"));
    }

    public function list($project_id)
    {
        // $project = Project::where("id", $project_id)->with(["project_methods"])->firstOrfail();
        $project_methods = ProjectMethod::where("project_id", $project_id)->with(["method"])->latest()->get();

        return Datatables::of($project_methods)
            ->addIndexColumn()
            ->addColumn('method', function ($project_method) {
                return $project_method->method->name;
            })
            ->addColumn('name', function ($project_method) use ($project_id) {
                $label = $project_method->name;
                $attributes = collect([
                    "href" => route("project_method.edit", [
                        "project" => $project_id,
                        "method" => $project_method->id
                    ])
                ]);
                return view("components.linkC", compact("label", "attributes"));
            })
            ->addColumn('action', function ($project_method) use ($project_id) {
                return view("pages.project.components.show-table-button-action", compact("project_method", "project_id"));
            })
            ->rawColumns(['action', "method", "name"])
            ->make(true);
    }

    public function get_attribute_keys()
    {
        $sql = "SELECT DISTINCT JSON_KEYS(attributes) AS attribute_keys FROM alternatives;";
        $get_dk = DB::select($sql);
        $attribute_keys = [];
        if (count($get_dk) > 0) {
            foreach (json_decode(DB::select($sql)[0]->attribute_keys) as $key) {
                $attribute_keys[] = [
                    "key" => $key,
                    "key_slug" => Str::slug($key),
                ];
            }
        }
        return $attribute_keys;
    }

    public function get_default(Request $request)
    {
        $methods = DB::table('methods')->get();
        // $alternative_taxonomy_keys = DB::table('alternative_taxonomies')
        //     ->distinct('key_slug')
        //     ->get(['key', 'key_slug']);
        $attribute_keys = $this->get_attribute_keys();

        return response()->json(compact("methods", "attribute_keys"));
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
     * @param  \App\Http\Requests\StoreProjectMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectMethodRequest $request, $project_id)
    {

        $project_method = new ProjectMethod();
        $project_method->name = $request->name;
        $project_method->description = $request->description;
        $project_method->method_id = intval($request->method_id);
        $project_method->project_id = intval($project_id);
        $project_method->criteria_rasio_json = "";
        $project_method->save();

        $criterias = collect();
        foreach ($request->criterias as $key => $request_criteria) {
            $criteria = new Criteria();
            $criteria->name = $request_criteria["name"];
            $criteria->slug = $request_criteria["slug"];
            $criteria->type = $request_criteria["type"];
            $criteria->project_method_id = $project_method->id;
            $criteria->save();
            $criterias->push($criteria);
        }

        $criteria_rasios = collect();
        $criteria_rasio_json = collect();
        foreach ($request->criteria_rasios as $key => $req_criteria_rasio) {
            $criteria_rasio = new CriteriaRasio();
            $criteria_rasio->criteria_id_1 = $criterias->where("slug", $req_criteria_rasio["slugs"][0])->first()->id;
            $criteria_rasio->criteria_id_2 = $criterias->where("slug", $req_criteria_rasio["slugs"][1])->first()->id;
            $criteria_rasio->rasio = $req_criteria_rasio["rasio"];
            $criteria_rasio->save();
            $criteria_rasios->push($criteria_rasio);
            $criteria_rasio_json->push([
                // "criteria_id_1" => $criteria_rasio->criteria_id_1,
                // "criteria_id_2" => $criteria_rasio->criteria_id_2,
                "ids" => [$criteria_rasio->criteria_id_1, $criteria_rasio->criteria_id_2],
                "slugs" => [$req_criteria_rasio["slugs"][0], $req_criteria_rasio["slugs"][1]],
                "rasio" => $criteria_rasio->rasio,
            ]);
        }

        $criteria_rasio_json = $criteria_rasio_json->toJson();
        $project_method->criteria_rasio_json = $criteria_rasio_json;
        $project_method->save();

        return response()->json(compact("project_method", "criterias", "criteria_rasios"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectMethod  $project_method
     * @return \Illuminate\Http\Response
     */
    public function show($project_method_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectMethod  $project_method
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id, $project_method_id)
    {
        $project_method = ProjectMethod::where("id", $project_method_id)->with(["criterias", "project"]);
        $project_method = $project_method->firstOrFail();

        // return response()->json($project_method);

        $methods = Method::all();
        // $alternative_taxonomy_keys = AlternativeTaxonomy::distinct("key_slug")->get(["key", "key_slug"]);
        $attribute_keys = collect($this->get_attribute_keys())->toArray();

        return view("pages.project_method.edit", compact("project_method", "methods", "attribute_keys"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectMethodRequest  $request
     * @param  \App\Models\ProjectMethod  $project_method
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectMethodRequest $request, $project_id, $project_method_id)
    {
        // return response()->json($request->all());

        $project_method = ProjectMethod::where("id", $project_method_id)->firstOrFail();
        $project_method->name = $request->name;
        $project_method->description = $request->description;
        $project_method->method_id = intval($request->method_id);
        $project_method->criteria_rasio_json = "";
        $project_method->save();

        $criterias = collect();
        foreach ($request->criterias as $key => $request_criteria) {
            $criteria = Criteria::where("project_method_id", $project_method->id)->where("slug", $request_criteria["slug"])->first();
            if (!$criteria) {
                $criteria = new Criteria();
                $criteria->name = $request_criteria["name"];
                $criteria->slug = $request_criteria["slug"];
                $criteria->project_method_id = $project_method->id;
            }
            $criteria->checked = $request_criteria["checked"];
            $criteria->type = $request_criteria["type"];
            $criteria->save();
            $criterias->push($criteria);
        }

        $criteria_rasios = collect();
        $criteria_rasio_json = collect();
        foreach ($request->criteria_rasios as $key => $req_crit_rasio) {
            $criteria_id_1 = $criterias->where("slug", $req_crit_rasio["slugs"][0])->first()->id;
            $criteria_id_2 = $criterias->where("slug", $req_crit_rasio["slugs"][1])->first()->id;
            $criteria_rasio = CriteriaRasio::where("criteria_id_1", $criteria_id_1)->where("criteria_id_2", $criteria_id_2)->first();
            if (!$criteria_rasio) {
                $criteria_rasio = new CriteriaRasio();
                $criteria_rasio->criteria_id_1 = $criteria_id_1;
                $criteria_rasio->criteria_id_2 = $criteria_id_2;
            }
            $criteria_rasio->rasio = $req_crit_rasio["rasio"];
            $criteria_rasio->save();
            $criteria_rasios->push($criteria_rasio);
            $criteria_rasio_json->push([
                "ids" => [$criteria_rasio->criteria_id_1, $criteria_rasio->criteria_id_2],
                "slugs" => [$req_crit_rasio["slugs"][0], $req_crit_rasio["slugs"][1]],
                "rasio" => $criteria_rasio->rasio,
            ]);
        }

        $criteria_rasio_json = $criteria_rasio_json->toJson();
        $project_method->criteria_rasio_json = $criteria_rasio_json;
        $project_method->save();

        return response()->json(compact("project_method", "criterias", "criteria_rasios"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectMethod  $project_method
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $project_method_id)
    {
        return response()->json(ProjectMethod::where("id", $project_method_id)->delete());
    }
}
