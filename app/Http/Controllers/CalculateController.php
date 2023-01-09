<?php

namespace App\Http\Controllers;

use App\Models\Calculate;
use App\Http\Requests\StoreCalculateRequest;
use App\Http\Requests\UpdateCalculateRequest;
use App\Models\Algorithm;
use App\Models\Alternative;
use App\Models\AlternativeTaxonomy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CalculateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // For development
    public $use_static_criterias = false;

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
    public function store(StoreCalculateRequest $request, $project_id, $project_method_id)
    {
        $algorithm = Algorithm::find($request->algorithm);
        $name = $request->name;
        if (!$name) $name = "Calculate $algorithm->name";
        $calculate = new Calculate();
        $calculate->name = $name;
        $calculate->description =  $request->description;
        $calculate->project_method_id = $project_method_id;
        $calculate->algorithm_id = $request->algorithm;
        $calculate->save();

        // $count_alternatives = count($alternatives);
        // return response()->json(compact("alternatives","calculate", "project_id", "project_method_id"));
        return redirect()->route("calculate.show", [
            "project" => $project_id,
            "project_method" => $project_method_id,
            "calculate" => $calculate->id
        ]);
    }

    public function get_attribute_keys($project_id)
    {
        $sql = "SELECT DISTINCT JSON_KEYS(attributes) AS attribute_keys FROM alternatives where project_id = $project_id;";
        $get_attr_key = DB::select($sql);
        $attribute_keys = [];

        if ($get_attr_key && $get_attr_key[0] && $get_attr_key[0]->attribute_keys) {
            $get_attr_key = $get_attr_key[0]->attribute_keys;
            return json_decode($get_attr_key);
        }
        return $attribute_keys;
    }

    public function get_alternative($project_id, $where_attributes = [])
    {
        DB::statement("SET SQL_MODE=''");
        $sql = "SELECT DISTINCT JSON_KEYS(attributes) AS attribute_keys FROM alternatives;";

        $sql_select = [
            // "a.id",
            // "a.name",
            // "a.description",
            // "a.attributes",
            // "a.user_id",
            // "a.project_id",
            // "a.created_at",
            // "a.updated_at",
            "*",
        ];
        $attribute_keys = $this->get_attribute_keys($project_id);
        foreach ($attribute_keys as $key) {
            $sql_select[] = "JSON_UNQUOTE(JSON_VALUE(attributes, '$.$key')) AS `$key`";
        }
        $sql_select = join(", ", $sql_select);
        $sql = "$sql_select";

        $alternatives = Alternative::query();
        $alternatives = $alternatives->select(DB::raw("$sql"));
        $alternatives = $alternatives->whereRaw("project_id = $project_id");

        if (count($where_attributes) > 0) {
            foreach ($where_attributes as $key => $where) {
                if (count($where) >= 2) {
                    $key = $where[0];
                    $separator = "=";
                    $value = $where[1];
                    if (count($where) == 3) {
                        $separator = $where[1];
                        $value = $where[2];
                    }
                    $alternatives = $alternatives->whereRaw("JSON_EXTRACT(attributes, '$.$key') $separator $value");
                }
            }
        }

        return $alternatives;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calculate  $calculate
     * @return \Illuminate\Http\Response
     */
    public function get_alternative_2($request, $calculate)
    {
        $alternatives = Alternative::query();
        foreach ($calculate->project_method->criterias as $key => $criteria) {
            if ($criteria->checked == 1) {
                $alternatives = $alternatives->where("attributes", "LIKE", "%\"$criteria->name\"%");
            }
        }

        $per_page = intval($request->get("paginate"));
        // $per_page = 60;
        $page = intval($request->get("page"));
        $skip = ($page - 1) * $per_page;

        $alternatives = $alternatives->skip($skip)->take($per_page);
        $alternatives = $alternatives->get(["id", "uuid", "name", "attributes"]);

        foreach ($alternatives as $alternative) {
            $alternative["attributes"] =  collect(json_decode($alternative->attributes))->toBase();
        }

        return response()->json(compact("alternatives"));
        // return response()->json(compact("alternatives", "per_page", "page", "skip"));
    }

    public function alternative_list(Request $request, $project_id, $project_method_id, $calculate_id)
    {
        // $calculate = Calculate::where("id", $calculate_id)->with(["algorithm", "project_method", "project_method.criterias"])->get()->first();

        $calculate = Calculate::where("id", $calculate_id)->with(["algorithm", "project_method", "project_method.criterias"])->get()->first();
        $criterias = $calculate->project_method->criterias;
        if ($this->use_static_criterias) $criterias = $this->static_criterias();

        if ($request->event == "metadata") {
            $alternative_count = DB::table("alternatives")->count();
            // $alternative_count = 60;
            return response()->json(compact("alternative_count", "calculate", "criterias"));
        }


        return $this->get_alternative_2($request, $calculate);
        // $alternatives = $this->get_alternative_2($request, $calculate);
        // return response()->json(compact("alternatives"));
    }

    public function show(Request $request, $project_id, $project_method_id, $calculate_id)
    {
        $calculate = Calculate::where("id", $calculate_id)->with(["algorithm", "project_method", "project_method.criterias"])->get()->first();
        if ($this->use_static_criterias) {
            $calculate->project_method->criterias = $this->static_criterias();
        }

        return view("pages.calculate.show", compact("calculate", "project_id", "project_method_id", "calculate_id"));
    }


    public function static_criterias()
    {
        $static_criterias = collect();
        $static_criterias_array = [
            [
                "id" => 4,
                "name" => "Rata-Rata Pemasukan",
                "slug" => "rata-rata-pemasukan",
                "type" => "cost",
                "weight" => 0.291,
                "checked" => 1,
                "project_method_id" => 1,
                "user_id" => 1,
                // "created_at" => "2023-01-04T17:45:07.000000Z",
                // "updated_at" => "2023-01-04T18:32:57.000000Z"
            ],
            [
                "id" => 1,
                "name" => "Jumlah Anggota Keluarga",
                "slug" => "jumlah-anggota-keluarga",
                "type" => "benefit",
                "weight" => 0.276,
                "checked" => 1,
                "project_method_id" => 1,
                "user_id" => 1,
                // "created_at" => "2023-01-04T17:45:07.000000Z",
                // "updated_at" => "2023-01-04T18:32:57.000000Z"
            ],

            [
                "id" => 5,
                "name" => "Rata-Rata Pengeluaran",
                "slug" => "rata-rata-pengeluaran",
                "type" => "benefit",
                "weight" => 0.308,
                "checked" => 1,
                "project_method_id" => 1,
                "user_id" => 1,
                // "created_at" => "2023-01-04T17:45:07.000000Z",
                // "updated_at" => "2023-01-04T18:32:57.000000Z"
            ],
            [
                "id" => 2,
                "name" => "Luas Lantai",
                "slug" => "luas-lantai",
                "type" => "cost",
                "weight" => 0.089,
                "checked" => 1,
                "project_method_id" => 1,
                "user_id" => 1,
                // "created_at" => "2023-01-04T17:45:07.000000Z",
                // "updated_at" => "2023-01-04T18:32:57.000000Z"
            ],
            [
                "id" => 3,
                "name" => "Rata-Rata Listrik",
                "slug" => "rata-rata-listrik",
                "type" => "cost",
                "weight" => 0.036,
                "checked" => 1,
                "project_method_id" => 1,
                "user_id" => 1,
                // "created_at" => "2023-01-04T17:45:07.000000Z",
                // "updated_at" => "2023-01-04T18:32:57.000000Z"
            ],

            [
                "id" => 6,
                "name" => "Kecamatan",
                "slug" => "kecamatan",
                "type" => "cost",
                "weight" => null,
                "checked" => 0,
                "project_method_id" => 1,
                "user_id" => 1,
                // "created_at" => "2023-01-04T17:46:04.000000Z",
                // "updated_at" => "2023-01-04T17:46:04.000000Z"
            ],
            [
                "id" => 7,
                "name" => "Nomor HP",
                "slug" => "nomor-hp",
                "type" => "cost",
                "weight" => null,
                "checked" => 0,
                "project_method_id" => 1,
                "user_id" => 1,
                // "created_at" => "2023-01-04T17:46:04.000000Z",
                // "updated_at" => "2023-01-04T17:46:04.000000Z"
            ]
        ];

        $static_criterias = collect(json_decode(collect($static_criterias_array)->toJson()));
        return $static_criterias;
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
