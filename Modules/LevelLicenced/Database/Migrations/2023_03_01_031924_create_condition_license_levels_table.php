<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condition_license_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('license_levels')->onDelete('set null');
            $table->integer('number_agent')->default(0)->nullable();
            $table->unsignedBigInteger('direct_level_id')->nullable();
            $table->foreign('direct_level_id')->references('id')->on('license_levels')->onDelete('set null');
            $table->integer('number_product')->default(0)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('condition_license_levels');
    }
};
