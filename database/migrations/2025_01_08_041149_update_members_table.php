<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('nic')->nullable()->after('member_name');
            $table->date('registered_date')->nullable()->after('email');
            $table->text('optional_notes')->nullable()->after('registered_date');
            $table->text('interests')->nullable()->after('optional_notes');
            $table->string('professional_quali')->nullable()->after('interests');
            $table->string('church_congregation')->nullable()->after('professional_quali');

            $table->renameColumn('religion_if_not_catholic', 'religion');
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
            $table->dropColumn('registered_date');
            $table->dropColumn('optional_notes');
            $table->dropColumn('interests');
            $table->dropColumn('professional_quali');
            $table->dropColumn('church_congregation');

            // Rename religion back to religion_if_not_catholic
            $table->renameColumn('religion', 'religion_if_not_catholic');
        });
    }
}
