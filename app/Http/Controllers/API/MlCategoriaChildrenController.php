<?php

namespace App\Http\Controllers\API;

use App\MlCategoriaChildren;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MlCategoriaChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return MlCategoriaChildren::with('mlsubcategoria')->where('categoria', '=', $request->ml_id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($array)
    {

        foreach ($array as $cat) {
            $categoria = MlCategoriaChildren::Create([
                'categoria' => $cat['categoria'],
                'child' => $cat['child']
            ]);
        }

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MlCategoriaChildren  $mlCategoriaChildren
     * @return \Illuminate\Http\Response
     */
    public function show(MlCategoriaChildren $mlCategoriaChildren)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MlCategoriaChildren  $mlCategoriaChildren
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MlCategoriaChildren $mlCategoriaChildren)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MlCategoriaChildren  $mlCategoriaChildren
     * @return \Illuminate\Http\Response
     */
    public function destroy(MlCategoriaChildren $mlCategoriaChildren)
    {
        //
    }
}
