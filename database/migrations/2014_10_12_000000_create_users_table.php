<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->date('dob');
            $table->string('phone', 15)->unique();
            $table->string('gender', 6);
            $table->string('avatar')->default('/storage/user_data/patient/avatar_default.png');
            $table->string('blood_group', 3)->nullable();
            //$table->bigInteger('user_role_id')->default(2);
            $table->text('location')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('blocked')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->boolean('is_admin')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
}
