<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_datas', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('resume_link')->nullable();
            $table->string('position_applied')->nullable();
            $table->string('about_self')->nullable();
            $table->integer('status')->default(0);            
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
        Schema::dropIfExists('applicant_datas');
    }
}
