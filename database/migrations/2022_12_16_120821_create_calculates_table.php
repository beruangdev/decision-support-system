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
        Schema::create('calculates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreignId('algorithm_id')->references('id')->on('algorithms')->onDelete("cascade");
            $table->foreignId('project_method_id')->references('id')->on('project_methods')->onDelete("cascade");
            // TODO: Delete filters table, just use filters column
            $table->json("filters")->default("[]");
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
        Schema::dropIfExists('calculates');
    }
};
