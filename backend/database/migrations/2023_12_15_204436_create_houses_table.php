<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string("water");
            $table->string("gas");
            $table->string("electricity");
            $table->string("sewer");

            $table->string("walls");
            $table->string("condition");
            $table->string("roof");
            $table->string("floor");
            $table->integer("level_count");
            $table->boolean("has_garage");

            $table->string("hot_water");
            $table->string("heating");
            $table->string("bath");
            $table->string("bathroom");

            $table->integer("room_count");
            $table->integer("area");
            $table->integer("kitchen_area");
            $table->integer("land_area");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('houses');
    }
};
