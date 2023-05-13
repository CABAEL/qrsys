<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->string('id');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('age');
            $table->string('gender');
            $table->string('birthday');
            $table->string('address');
            $table->string('email');
            $table->string('mobile_number');
            //$table->string('profile_img')->nullable();
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
        Schema::dropIfExists('user_profiles');
    }
}
