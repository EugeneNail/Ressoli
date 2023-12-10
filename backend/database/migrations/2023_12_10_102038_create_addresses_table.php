<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string("number");
            $table->string("unit")->nullable();
            $table->string("type_of_street");
            $table->string("street");
            $table->string("city");
            $table->string("postal_code")->nullable();
            $table->decimal("longitude", 10, 7);
            $table->decimal("latitude", 10, 7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('addresses');
    }
};
