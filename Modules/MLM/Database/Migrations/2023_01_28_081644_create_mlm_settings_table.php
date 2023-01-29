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
        Schema::create('mlm_level_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('key')->nullable();
            $table->integer('commission')->nullable()->default(0);
            $table->enum('commission_type',['percentage','number'])->nullable()->default('percentage');
            $table->string('commission_group')->nullable()->default('direct');
            // mlm_level_id
            $table->unsignedBigInteger('mlm_level_id')->nullable();
            $table->foreign('mlm_level_id')->references('id')->on('mlm_levels')->onDelete('cascade');
            // mlm_indirect_level_id
            $table->unsignedBigInteger('mlm_indirect_level_id')->nullable();
            $table->foreign('mlm_indirect_level_id')->references('id')->on('mlm_levels')->onDelete('cascade');
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
        Schema::dropIfExists('mlm_level_settings');
    }
};
