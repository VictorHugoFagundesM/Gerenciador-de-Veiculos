<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('brand_id')->nullable();
            $table->foreignId('vehicle_type_id')->nullable();
            $table->boolean('is_avaliable');
            $table->string('name', 80);
            $table->string('year', 10);
            $table->string('color', 20);
            $table->double('price_per_day', 8, 2);
            $table->string('informations', 400)->nullable();
            $table->timestamp('begin_avaliable_date');
            $table->timestamp('end_avaliable_date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
