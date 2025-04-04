<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->integer('mal_id')->nullable()->unique();
            $table->string('title', 255);
            $table->string('english_title', 255)->nullable();
            $table->string('japanese_title')->nullable();
            $table->text('image_url')->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->integer('episodes')->nullable();
            $table->string('status', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->text('synopsis')->nullable();
            $table->float('score')->nullable();
            $table->dateTime('aired_from')->nullable();
            $table->dateTime('aired_to')->nullable();
            $table->string('season')->nullable();
            $table->integer('season_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
