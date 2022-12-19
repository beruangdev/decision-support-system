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
        Schema::create('alternative_taxonomies', function (Blueprint $table) {
            $table->id();
            $table->string("key");
            $table->string("key_slug");
            $table->text("value");
            $table->text("value_slug");
            $table->foreignId('alternative_id')->references('id')->on('alternatives')->onDelete("cascade");
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
        Schema::dropIfExists('alternative_taxonomies');
    }
};
