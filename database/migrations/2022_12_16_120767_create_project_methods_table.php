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
        Schema::create('project_methods', function (Blueprint $table) {
            $table->id();
            $table->boolean("status")->default(false);
            $table->string("name");
            $table->text("description")->nullable();
            $table->text("criteria_rasio_json")->nullable();

            $table->foreignId('method_id')->references('id')->on('methods')->onDelete("cascade");
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete("cascade");
            $table->foreignId('user_id')->references('id')->on('users')->onDelete("cascade");
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
        Schema::dropIfExists('project_methods');
    }
};
