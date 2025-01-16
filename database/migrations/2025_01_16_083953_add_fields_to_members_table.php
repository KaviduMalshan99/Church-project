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
            $table->date('baptized_date')->nullable()->after('baptized'); 
            $table->unsignedBigInteger('academic_quali')->nullable()->after('baptized_date'); 
            $table->string('member_title', 50)->nullable()->after('member_id'); 
            $table->date('married_date')->nullable()->after('civil_status'); 


            $table->foreign('academic_quali')->references('id')->on('academic_qualifications')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['academic_quali']); 
            $table->dropColumn(['baptized_date', 'academic_quali', 'member_title', 'married_date']); 
        });
    }
};
