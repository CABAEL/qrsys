<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('client_users', function (Blueprint $table) {
            $table->id('client_user_id')->unique();
            $table->integer('client_id');
            $table->string('picture',255)->nullable();
            $table->integer('user_id')->unique();;
            $table->string('fname',255);
            $table->string('mname',255)->nullable();
            $table->string('lname',255);
            $table->string('contact_no',20)->nullable();
            $table->string('email',60)->nullable();
            $table->string('address',255)->nullable();
            $table->string('description',255)->nullable();
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
        Schema::dropIfExists('client_users');
    }
}
