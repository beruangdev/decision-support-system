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
        Schema::create('criteria_rasios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id_1')->references('id')->on('criterias')->onDelete("cascade");
            $table->foreignId('criteria_id_2')->references('id')->on('criterias')->onDelete("cascade");
            $table->float('rasio');
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
        Schema::dropIfExists('criteria_rasios');
    }
};
