<?php

use App\Models\Address;
use App\Models\Option;
use Database\Seeders\AddressOptionsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->string("name");
            $table->string("value");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('options');
    }
};
