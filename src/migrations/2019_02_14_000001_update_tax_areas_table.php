<?php

use Appleton\Taxes\Models\Tax;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateTaxAreasTable extends Migration
{
    protected $taxes = 'taxes';
    protected $tax_areas = 'tax_areas';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->taxes, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('class');
        });

        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->integer('tax_id')->nullable()->index();
            $table->integer('home_governmental_unit_area_id')->nullable()->index();
            $table->integer('work_governmental_unit_area_id')->nullable()->index();
        });

        DB::table($this->tax_areas)
            ->get()
            ->each(function($tax_area) {
                $tax = new Tax();
                $tax->name = $tax_area->name;
                $tax->class = $tax_area->tax;
                $tax->save();

                DB::table($this->tax_areas)
                    ->where('id', $tax_area->id)
                    ->update([
                        'tax_id' => $tax->id,
                    ]);
            });

        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->integer('tax_id')->nullable(false)->change();
        });

        DB::table($this->tax_areas)
            ->get()
            ->each(function($tax_area) {
                if ($tax_area === TaxArea::BASED_ON_HOME_LOCATION) {
                    $tax_area->home_governmental_unit_area_id = $tax_area->governmental_unit_area_id;
                } else if ($tax_area === TaxArea::BASED_ON_WORK_LOCATION) {
                    $tax_area->work_governmental_unit_area_id = $tax_area->governmental_unit_area_id;
                }
            });

        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('tax');
            $table->dropColumn('governmental_unit_area_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
