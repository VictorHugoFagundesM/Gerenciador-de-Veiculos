<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->nullable();
            $table->foreignId('renter_id')->nullable();
            $table->foreignId('hirer_id')->nullable();
            $table->timestamp('begin_date');
            $table->timestamp('end_date');
            $table->timestamps();

            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('set null');
            $table->foreign('renter_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('hirer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rents');
    }
}
