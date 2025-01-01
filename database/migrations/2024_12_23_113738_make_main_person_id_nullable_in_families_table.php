<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeMainPersonIdNullableInFamiliesTable extends Migration
{
    public function up()
    {
        Schema::table('families', function (Blueprint $table) {
            $table->unsignedBigInteger('main_person_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('families', function (Blueprint $table) {
            $table->unsignedBigInteger('main_person_id')->nullable(false)->change();
        });
    }

};
