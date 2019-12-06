<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlCategoriaChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ml_categoria_childrens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('categoria');
            $table->string('child');
            $table->timestamps();
            // Foreing
            $table->foreign('child')->references('ml_id')->on('ml_sub_categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ml_categoria_childrens');
    }
}
