<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->string('id_site');
            $table->string('currency');
            $table->string('name');
            $table->timestamps();
            $table->primary('name');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('user_ml', 50)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('country')->nullable();
            $table->string('type')->default('user');
            $table->mediumText('bio')->nullable();
            $table->string('photo')->default('profile.png');
            $table->rememberToken();
            //            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            // Relations
            // $table->foreign('country')->references('name')->on('sites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
        Schema::dropIfExists('users');
    }
}
