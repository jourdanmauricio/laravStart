<?php

namespace App\Http\Controllers\API;

use App\MlSubCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MlSubCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($array)
    {
        DB::table('ml_categoria_childrens')->truncate();
        DB::table('ml_sub_categorias')->delete();
        foreach ($array as $cat) {
            $categoria = MlSubCategoria::Create([
                'ml_id' => $cat['id'],
                'name' => $cat['name'],
                'cant_items' => $cat['total_items_in_this_category']
            ]);
        }

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MlSubCategoria  $mlSubCategoria
     * @return \Illuminate\Http\Response
     */
    public function show(MlSubCategoria $mlSubCategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MlSubCategoria  $mlSubCategoria
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        \Artisan::call('import-categorias:json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MlSubCategoria  $mlSubCategoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(MlSubCategoria $mlSubCategoria)
    {
        //
    }
}
