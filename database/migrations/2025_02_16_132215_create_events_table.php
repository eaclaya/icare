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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('contact_phone', 50)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->integer('max_size')->nullable();
            $table->string('location_id')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
