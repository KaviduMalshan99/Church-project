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
        Schema::create('families', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('main_person_id'); // Reference to the main person
            $table->string('family_number')->unique(); // Auto-generated family number
            $table->string('family_name')->nullable(); // Nullable family name
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
