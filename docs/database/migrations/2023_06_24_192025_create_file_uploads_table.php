<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('file_group_id');
            $table->string('document_code',60);
            $table->string('file_name',255);
            $table->text('description')->nullable();
            $table->string('password',60)->nullable();
            $table->binary('blob_qr');
            $table->integer('status')->default(0);
            $table->integer('uploaded_by');
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
        Schema::dropIfExists('file_uploads');
    }
}