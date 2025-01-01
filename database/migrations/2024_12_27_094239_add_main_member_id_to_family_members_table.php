<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMainMemberIdToFamilyMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            // Add the main_member_id column
            $table->unsignedBigInteger('main_member_id')->nullable()->after('id');

            // Create a foreign key relationship (optional, if you want to enforce it)
            $table->foreign('main_member_id')->references('id')->on('members')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['main_member_id']);
            $table->dropColumn('main_member_id');
        });
    }
}
