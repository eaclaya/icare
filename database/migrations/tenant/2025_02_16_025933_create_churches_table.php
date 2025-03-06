<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("churches", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("nickname")->nullable();
            $table->string("campus_name")->nullable();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->unsignedBigInteger("location_id")->nullable();
            $table->json("meta")->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table
                ->foreign("location_id")
                ->references("id")
                ->on("locations")
                ->onDelete("cascade");
            $table
                ->foreign("parent_id")
                ->references("id")
                ->on("churches")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("churches");
    }
};
