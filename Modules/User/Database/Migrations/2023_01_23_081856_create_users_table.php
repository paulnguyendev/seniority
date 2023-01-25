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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('type')->default('user')->nullable()->comment('user: Thành viên, customer: Khách hàng, admin: Quản lý');;
            $table->string('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('address')->nullable();
            $table->string('token')->nullable();
            $table->string('code')->nullable();
            $table->integer('parent_id')->nullable();
            $table->json('bank_info')->nullable();
            $table->integer('_lft')->nullable();
            $table->integer('_rgt')->nullable();
            $table->string('status')->default('pending')->nullable();
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
        Schema::dropIfExists('users');
    }
};
