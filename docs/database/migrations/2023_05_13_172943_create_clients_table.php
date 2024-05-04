<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id')->unique();
            $table->integer('user_id')->unique();
            $table->string('client_name',60)->unique();
            $table->string('contact_no',20)->nullable();
            $table->string('email',60)->nullable();
            $table->string('address',255)->nullable();
            $table->string('description',255)->nullable();
            $table->string('logo')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('clients');
    }
}
