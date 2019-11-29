<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ml_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ml_id');
            $table->string('nickname', 50);
            $table->string('registration_date');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('country_id')->nullable();
            $table->string('email');
            $table->string('identification_number')->nullable();
            $table->string('identification_type')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone_area_code')->nullable();
            $table->string('phone_extension')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone_verified')->nullable();
            $table->string('alt_phone_area_code')->nullable();
            $table->string('alt_phone_extension')->nullable();
            $table->string('alt_phone_number')->nullable();
            $table->string('user_type')->nullable();
            $table->string('logo')->nullable();
            $table->string('points')->nullable();
            $table->string('site_id')->nullable();
            $table->string('permalink')->nullable();
            $table->string('seller_experience')->nullable();
            $table->string('seller_reputation_level_id')->nullable();
            $table->string('seller_power_seller_status')->nullable();
            $table->string('seller_transactions_canceled')->nullable();
            $table->string('seller_transactions_completed')->nullable();
            $table->string('seller_transactions_period')->nullable();
            $table->string('seller_ratings_negative')->nullable();
            $table->string('seller_ratings_neutral')->nullable();
            $table->string('seller_ratings_positive')->nullable();
            $table->string('seller_transactions_total')->nullable();
            $table->timestamps();
            // Relations
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ml_users');
    }
}
