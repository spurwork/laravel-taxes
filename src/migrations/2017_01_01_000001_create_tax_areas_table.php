<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTaxAreasTable extends Migration
{
    protected $tax_areas = 'tax_areas';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tax_areas, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('tax');
            $table->integer('governmental_unit_area_id')->index();
        });

        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->foreign('governmental_unit_area_id')->references('id')->on('governmental_unit_areas')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->tax_areas);
    }
}
