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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('dob');
            $table->string('pet_type');
            $table->unsignedBigInteger('primary_contact_id');
            $table->foreign('primary_contact_id')->references('id')->on('members');
            $table
                ->foreignId('location_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
