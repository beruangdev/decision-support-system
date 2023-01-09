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
            $table->string("name");
            $table->text("description")->nullable();
            $table->json("rasios")->default("[]")->nullable();

            $table->foreignId('method_id')->references('id')->on('methods')->onDelete("cascade");
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete("cascade");
            $table->foreignId('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
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
