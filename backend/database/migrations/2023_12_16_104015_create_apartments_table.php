<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->boolean("has_water");
            $table->boolean("has_gas");
            $table->boolean("has_electricity");
            $table->boolean("has_sewer");

            $table->string("condition");
            $table->string("walls");
            $table->float("ceiling");
            $table->integer("level");
            $table->integer("level_count");

            $table->boolean("has_heating");
            $table->boolean("has_hot_water");
            $table->string("bath");
            $table->string("bathroom");

            $table->float("area");
            $table->integer("room_count");
            $table->boolean("has_loggia");
            $table->boolean("has_balcony");
            $table->boolean("has_garage");

            $table->boolean("has_garbage_chute");
            $table->boolean("has_elevator");
            $table->boolean("is_corner");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('apartments');
    }
};
