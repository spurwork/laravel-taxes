<?php

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
                $id = DB::table($this->taxes)
                    ->insertGetId([
                        'name' => $tax_area->name,
                        'class' => $tax_area->tax,
                    ]);

                DB::table($this->tax_areas)
                    ->where('id', $tax_area->id)
                    ->update([
                        'tax_id' => $id,
                    ]);
            });

        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->integer('tax_id')->nullable(false)->change();
        });

        DB::table($this->tax_areas)
            ->get()
            ->each(function($tax_area) {
                if ($tax_area->based === TaxArea::BASED_ON_HOME_LOCATION) {
                    DB::table($this->tax_areas)
                        ->where('id', $tax_area->id)
                        ->update([
                            'home_governmental_unit_area_id' => $tax_area->governmental_unit_area_id,
                        ]);
                } else if ($tax_area->based === TaxArea::BASED_ON_WORK_LOCATION) {
                    DB::table($this->tax_areas)
                        ->where('id', $tax_area->id)
                        ->update([
                            'work_governmental_unit_area_id' => $tax_area->governmental_unit_area_id,
                        ]);
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
        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->string('name')->nullable()->unique();
            $table->string('tax')->nullable();
            $table->integer('governmental_unit_area_id')->nullable()->index();
        });

        DB::table($this->tax_areas)
            ->get()
            ->each(function($tax_area) {
                if ($tax_area->based === TaxArea::BASED_ON_HOME_LOCATION) {
                    DB::table($this->tax_areas)
                        ->where('id', $tax_area->id)
                        ->update([
                            'governmental_unit_area_id' => $tax_area->home_governmental_unit_area_id,
                        ]);
                } else if ($tax_area->based === TaxArea::BASED_ON_WORK_LOCATION) {
                    DB::table($this->tax_areas)
                        ->where('id', $tax_area->id)
                        ->update([
                            'governmental_unit_area_id' => $tax_area->work_governmental_unit_area_id,
                        ]);
                }
            });

        DB::table($this->tax_areas)
            ->get()
            ->each(function($tax_area) {
                $tax = DB::table($this->taxes)
                    ->where('id', $tax_area->tax_id)
                    ->first();

                DB::table($this->tax_areas)
                    ->where('id', $tax_area->id)
                    ->update([
                        'name' => $tax->name,
                        'tax' => $tax->class,
                    ]);
            });

        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('tax')->nullable(false)->change();
        });

        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->dropColumn('tax_id');
            $table->dropColumn('home_governmental_unit_area_id');
            $table->dropColumn('work_governmental_unit_area_id');
        });

        Schema::drop($this->taxes);
    }
}
