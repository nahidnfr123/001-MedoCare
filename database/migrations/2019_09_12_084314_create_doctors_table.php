<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('user_id')->unique()->unsigned();
            $table->biginteger('department_id')->unsigned();
            $table->string('nationality');
            $table->string('work_place_name');
            $table->string('work_place_document');
            $table->string('education');
            $table->integer('experience');
            $table->string('working_days')->nullable();
            $table->double('fees')->nullable();
            $table->text('about')->nullable();
            $table->boolean('email_sent')->default(0);
            $table->string('email_verification_token')->nullable();
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
        Schema::dropIfExists('doctors');
    }
}
