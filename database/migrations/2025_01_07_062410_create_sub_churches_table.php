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
        Schema::create('sub_churches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_church_id');
            $table->string('church_name');
            $table->string('location');
            $table->string('contact_info');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('parent_church_id')
                  ->references('id')
                  ->on('churches')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_churches');
    }
};
