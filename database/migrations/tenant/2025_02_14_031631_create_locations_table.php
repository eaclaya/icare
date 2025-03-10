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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('provider_id', 100)->nullable();
            $table->string('name');
            $table->string('street_number', 10)->nullable();
            $table->string('street');
            $table->string('city', 100);
            $table->string('county', 100)->nullable();
            $table->string('state', 100);
            $table->string('zip', 100);
            $table->string('country', 100)->nullable();
            $table->string('lat', 100)->nullable();
            $table->string('lng', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('phone', 100)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
