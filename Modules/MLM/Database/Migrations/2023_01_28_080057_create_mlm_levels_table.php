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
        Schema::create('mlm_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('short_name')->nullable();
            $table->integer('number_order')->nullable()->default(0);
            $table->integer('number_lead')->nullable()->default(0);
            $table->integer('number_child')->nullable()->default(1);
            $table->integer('child_id')->nullable();
            $table->unsignedBigInteger('mlm_type_id')->nullable();
            $table->foreign('mlm_type_id')->references('id')->on('mlm_types')->onDelete('cascade');
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('mlm_levels');
    }
};
