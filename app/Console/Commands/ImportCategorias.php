<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class ImportCategorias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-categorias:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesar e importar categorias desde json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = env('APP_FILES', '');
        shell_exec(__DIR__ . "/integriprod_categorias_ml.sh");

        // Importamos las categorias principales
        $jsondata = file_get_contents($path . 'categorias_ppal.json');
        $data = json_decode($jsondata, true);

        $controllerSubCat = app()->make('App\Http\Controllers\API\MlCategoriaController');
        $result = app()->call([$controllerSubCat, 'store'], [$data]);

        $this->info(print_r($result));

        // Importamos las categorias y childrens

        $jsondata = file_get_contents($path . 'categorias.json');

        $data = json_decode($jsondata, true);

        $array = [];
        $arrayChildrens = [];
        $contChildrens = 0;
        $cont = 0;

        foreach ($data as $key_ppal => $value) {
            if (!is_array($value)) { } else {
                foreach ($value as $key2 => $val) {
                    if (!is_array($val)) {
                        $array1[$key2] = $val;
                    } else {
                        foreach ($val as $key => $valor) {
                            $arrayChildrens[$contChildrens] = ['categoria' => $key_ppal, 'child' => $valor['id']];
                            $contChildrens++;
                        }
                    }
                }
            }
            $array[$key_ppal] = $array1;
            $cont = $cont + 1;
        }

        $controllerSubCat = app()->make('App\Http\Controllers\API\MlSubCategoriaController');
        $result = app()->call([$controllerSubCat, 'store'], [$array]);

        $this->info(print_r($result));

        $controllerCatChild = app()->make('App\Http\Controllers\API\MlCategoriaChildrenController');
        $result = app()->call([$controllerCatChild, 'store'], [$arrayChildrens]);

        $this->info(print_r($result));
    }
}
