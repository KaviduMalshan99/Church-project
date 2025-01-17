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
        Schema::table('members', function (Blueprint $table) {
            // Change the 'held_office_in_council' column to 'json' type to support multiple values
            $table->json('held_office_in_council')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Revert the 'held_office_in_council' column back to string if needed
            $table->string('held_office_in_council')->nullable()->change();
        });
    }
};
