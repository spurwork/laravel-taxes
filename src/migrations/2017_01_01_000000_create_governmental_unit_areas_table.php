<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGovernmentalUnitAreasTable extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->governmental_unit_areas, function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
        });

        DB::statement('ALTER TABLE'.$this->governmental_unit_areas.'ADD COLUMN area geometry');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->governmental_unit_areas);
    }
}
