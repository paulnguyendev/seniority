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
        Schema::create('license_agents', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('username')->nullable();
            $table->string('status')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('qrcode')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('_lft')->nullable();
            $table->string('_rgt')->nullable();
            $table->enum('is_suppend', ['0', '1'])->default('0')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('verify_code')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('license_levels')->onDelete('cascade');
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
        Schema::dropIfExists('license_agents');
    }
};
