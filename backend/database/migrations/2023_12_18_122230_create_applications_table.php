<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained();
            $table->foreignId("client_id")->constrained();
            $table->foreignId("address_id")->constrained();
            $table->unsignedBigInteger("applicable_id");
            $table->string("applicable_type");
            $table->boolean("is_active")->default(true);
            $table->string("contract");
            $table->integer("price");
            $table->boolean("has_mortgage");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('applications');
    }
};
