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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('family_no')->nullable(); 
            $table->string('member_id')->nullable(); 
            $table->string('member_name');
            $table->string('name_with_initials');
            $table->text('address');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('relationship_to_main_person')->nullable();
            $table->string('occupation')->nullable();
            $table->boolean('baptized')->default(false);
            $table->boolean('full_member')->default(false);
            $table->boolean('half_member')->default(false);
            $table->boolean('associate_member')->default(false);
            $table->boolean('methodist_member')->default(false);
            $table->boolean('sabbath_member')->default(false);
            $table->string('nikaya')->nullable();
            $table->string('religion_if_not_catholic')->nullable();
            $table->string('contact_info')->nullable();
            $table->string('email')->nullable();
            $table->boolean('held_office_in_council')->default(false);
            $table->string('image')->nullable(); // Image path or URL
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('family_no')->references('family_number')->on('families')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
