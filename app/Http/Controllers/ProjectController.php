<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Alternative;
use App\Models\AlternativeTaxonomie;
use App\Models\Method;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.project.index");
    }

    public function list()
    {
        $data = Project::where("user_id", Auth::id())->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($project) {
                $label = $project->name;
                $attributes = collect([
                    "href" => route("project.show", $project->id)
                ]);
                return view("components.link", compact("label", "attributes"));
            })
            ->addColumn('action', function ($project) {
                return view("pages.project.components.table-button-action", compact("project"));
            })
            ->rawColumns(['action', "name"])
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
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $project = new Project();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->user_id = Auth::id();
        $project->save();

        return response()->json(compact("project"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        // dd($keys);
        $methods = Method::all();
        $alternative_taxonomy_keys = AlternativeTaxonomie::distinct("key_slug")->get(["key", "key_slug"]);
        // dd($alternative_taxonomy_keys);
        // dd($sql_select);

        // $alternatives = $this->alternative_query_1($alternative_taxonomy_keys);
        // $alternatives = $this->alternative_query_2($alternative_taxonomy_keys);
        // $alternatives = $this->alternative_query_3($alternative_taxonomy_keys);
        // $alternatives = $this->alternative_query_4($alternative_taxonomy_keys);

        // $alternatives = $alternatives->limit(10);
        // $alternatives = $alternatives->get();
        // $alternatives = $alternatives->paginate(10);
        // $alternatives = $alternatives->toSql();

        // dd($alternatives);
        
        return view("pages.project.show", compact("project", "methods", "alternative_taxonomy_keys"));
    }

    public function alternative_query_1($alternative_taxonomy_keys)
    {
        $sql_select = [
            "a.id",
            "a.name",
            "a.description",
            "a.taxonomie_strings",
            "a.user_id",
            "a.created_at",
            "a.updated_at",
        ];
        foreach ($alternative_taxonomy_keys as $key => $alternative_taxonomy_key) {
            $slug = $alternative_taxonomy_key->key_slug;
            array_push($sql_select, DB::raw("MAX(IF(at.key_slug = '$slug', at.value, NULL)) AS `$slug`"));
        }
        DB::statement("SET SQL_MODE=''");
        $alternatives = Alternative::from('alternatives as a');
        $alternatives = $alternatives->select($sql_select);
        $alternatives = $alternatives->join('alternative_taxonomies AS at', 'a.id', '=', 'at.alternative_id');
        $alternatives = $alternatives->groupBy("a.id");

        // Alternative::from('alternatives as a')->select($sql_select)->join('alternative_taxonomies AS at', 'a.id', '=', 'at.alternative_id')->groupBy("a.id")->limit(2)
        return $alternatives;
    }


    public function alternative_query_2($alternative_taxonomy_keys, $req_where = null)
    {
        $sql_select = [
            "a.id",
            "a.name",
            "a.description",
            "a.taxonomie_strings",
            "a.user_id",
            "a.created_at",
            "a.updated_at",
        ];
        foreach ($alternative_taxonomy_keys as $key => $alternative_taxonomy_key) {
            $slug = $alternative_taxonomy_key->key_slug;
            array_push($sql_select, "MAX(IF(at.key_slug = '$slug', at.value, NULL)) AS `$slug`");
        }
        $sql_select = join(", ", $sql_select);
        $where = "";
        if ($req_where != null) {
            // $where = "WHERE ";
            // $where .= "`jumlah-anggota-keluarga`<=2 ";
            // $where .= "`jumlah-anggota-keluarga` IS NULL ";
        }

        $sql = "SELECT * FROM ( SELECT $sql_select FROM alternatives a LEFT JOIN alternative_taxonomies AS at ON a.id = at.alternative_id GROUP BY a.id ) AS alternatives  $where";
        DB::statement("SET SQL_MODE=''");
        $alternatives = DB::select($sql);
        return $alternatives;
    }

    public function alternative_query_3($alternative_taxonomy_keys, $req_where = null)
    {
        $sql_select = [
            "a.id",
            "a.name",
            "a.description",
            "a.taxonomie_strings",
            "a.user_id",
            "a.created_at",
            "a.updated_at",
        ];
        foreach ($alternative_taxonomy_keys as $key => $alternative_taxonomy_key) {
            $slug = $alternative_taxonomy_key->key_slug;
            array_push($sql_select, "MAX(IF(at.key_slug = '$slug', at.value, NULL)) AS `$slug`");
        }
        $sql_select = join(", ", $sql_select);
        $sql = "SELECT $sql_select FROM alternatives a LEFT JOIN alternative_taxonomies AS at ON a.id = at.alternative_id GROUP BY a.id";
        DB::statement("SET SQL_MODE=''");
        // $sub_alternatives = Alternative::from('alternatives as a');
        // $sub_alternatives = $sub_alternatives->select($sql_select);
        // $sub_alternatives = $sub_alternatives->join('alternative_taxonomies AS at', 'a.id', '=', 'at.alternative_id');
        // $sub_alternatives = $sub_alternatives->groupBy("a.id");
        // $sub_alternatives = $sub_alternatives->limit(2);
        $alternatives = Alternative::query();
        $alternatives = $alternatives->from(DB::raw("($sql asc) as `alternatives`"));
        // $alternatives = $alternatives->where("jumlah-anggota-keluarga", NULL);


        return $alternatives;
    }

    public function alternative_query_4($alternative_taxonomy_keys, $req_where = null)
    {
        $sql_select = [
            "a.id",
            "a.name",
            "a.description",
            "a.taxonomie_strings",
            "a.user_id",
            "a.created_at",
            "a.updated_at",
        ];
        foreach ($alternative_taxonomy_keys as $key => $alternative_taxonomy_key) {
            $slug = $alternative_taxonomy_key->key_slug;
            array_push($sql_select, "MAX(IF(at.key_slug = '$slug', at.value, NULL)) AS `$slug`");
        }
        $sql_select = join(", ", $sql_select);
        $sql = "SELECT $sql_select FROM alternatives a LEFT JOIN alternative_taxonomies AS at ON a.id = at.alternative_id GROUP BY a.id";
        DB::statement("SET SQL_MODE=''");
        // $sub_alternatives = Alternative::from('alternatives as a');
        // $sub_alternatives = $sub_alternatives->select($sql_select);
        // $sub_alternatives = $sub_alternatives->join('alternative_taxonomies AS at', 'a.id', '=', 'at.alternative_id');
        // $sub_alternatives = $sub_alternatives->groupBy("a.id");
        // $sub_alternatives = $sub_alternatives->limit(2);
        $alternatives = DB::query();
        $alternatives = $alternatives->from(DB::raw("($sql asc) as `alternatives`"));
        // $alternatives = $alternatives->where("jumlah-anggota-keluarga", NULL);

        return $alternatives;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();

        return response()->json(compact("project"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(true);
    }
}
