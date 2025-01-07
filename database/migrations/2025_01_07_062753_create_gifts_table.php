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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('gift_code')->unique();
            $table->unsignedBigInteger('sender_id')->nullable(); // Nullable foreign key to members
            $table->unsignedBigInteger('receiver_id')->nullable(); // Nullable foreign key to members
            $table->string('receiver_address');
            $table->string('greeting_title');
            $table->string('greeting_description')->nullable();
            $table->string('gift_status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
