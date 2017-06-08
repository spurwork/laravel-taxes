<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGovernmentalUnitAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('governmental_unit_areas', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
        });

        DB::statement('ALTER TABLE governmental_unit_areas ADD COLUMN area geometry');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('governmental_unit_areas');
    }
}
