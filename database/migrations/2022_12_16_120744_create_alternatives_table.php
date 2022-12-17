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
            $table->id();

            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('salary')->nullable();
            $table->string('nik')->nullable();
            $table->string('nkk')->nullable();
            $table->foreignId('villager_id')->references('id')->on('villages');
            $table->foreignId('kecamatan_id')->references('id')->on('kecamatans');
            $table->foreignId('kabupaten_id')->references('id')->on('kabupatens');
            $table->foreignId('province_id')->references('id')->on('provinces');

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
        Schema::dropIfExists('alternatives');
    }
};
