<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_license_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('personal_payout')->nullable();
            $table->integer('team_overrides')->nullable();
            $table->string('is_break')->default('0')->nullable();
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
        Schema::dropIfExists('non_license_levels');
    }
};
