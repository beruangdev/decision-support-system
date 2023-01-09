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
        Schema::create('alternatives', function (Blueprint $table) {
            // $table->uuid("id")->unique()->primary();
            $table->id();
            $table->string("uuid", 225);
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('attributes')->default('{}');

            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('project_id')->references('id')->on('projects');
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
        Schema::dropIfExists('alternatives');
    }
};
