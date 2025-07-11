<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesSentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages_sent', function (Blueprint $table) {
            $table->id(); 
            $table->string('member_id'); 
            $table->text('message');
            $table->string('status')->default('pending'); 
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages_sent');
    }
}
