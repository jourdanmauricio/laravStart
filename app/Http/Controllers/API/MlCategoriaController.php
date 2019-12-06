<?php

namespace App\Http\Controllers\API;

use App\MlCategorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MlCategoriaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin')) {

            // return MlCategorias::All();
            return MlCategorias::select('id', 'ml_id', 'name', 'created_at')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($array)
    {
        DB::table('ml_categorias')->truncate();

        foreach ($array as $cat) {
            $categoria = MlCategorias::Create([
                'ml_id' => $cat['id'],
                'name' => $cat['name']
            ]);
        }

        return response()->json(['message' => 'Success'], 200);
        //   return $request;
    }
}
