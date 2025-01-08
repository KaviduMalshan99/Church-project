<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGiftsTable extends Migration
{
    public function up()
    {
        Schema::table('gifts', function (Blueprint $table) {
            // Drop the unwanted columns
            $table->dropColumn([
                'gift_code',
                'receiver_id',
                'receiver_address',
                'greeting_title',
                'greeting_description',
                'gift_status',
            ]);

            // Add the new columns
            $table->string('sender_id')->after('id'); 
            $table->string('type')->after('sender_id');
            $table->decimal('amount', 10, 2)->after('type'); 

        });
    }

    public function down()
    {
        Schema::table('gifts', function (Blueprint $table) {
            // Revert the changes in case of rollback
            $table->string('gift_code')->unique();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('receiver_address');
            $table->string('greeting_title');
            $table->string('greeting_description')->nullable();
            $table->string('gift_status')->default('Pending');
            
            // Drop the newly added columns
            $table->dropColumn([
                'sender_id',
                'type',
                'amount',
            ]);

            // Drop foreign key constraint
            $table->dropForeign(['sender_id']);
        });
    }
}
