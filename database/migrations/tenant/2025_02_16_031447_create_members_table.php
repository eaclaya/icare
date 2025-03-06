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
        Schema::create("members", function (Blueprint $table) {
            $table->id();
            $table->string("first_name", 100);
            $table->string("last_name", 100);
            $table->string("email", 100)->nullable()->index();
            $table->string("phone", 100)->nullable();
            $table->string("gender", 10)->nullable();
            $table->date("dob")->nullable();
            $table->string("url_avatar")->nullable();
            $table
                ->foreignId("location_id")
                ->nullable()
                ->constrained()
                ->onDelete("cascade");
            $table->json("meta")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("members");
    }
};
