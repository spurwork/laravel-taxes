<?php
 use Appleton\Taxes\Countries\US\Nebraska\NebraskaIncome\NebraskaIncome;
use Appleton\Taxes\Countries\US\Nebraska\NebraskaUnemployment\NebraskaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNebraskaIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        Schema::create('nebraska_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('allowances')->default(0);
            $table->string('filing_status')->nullable();
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Nebraska Income Tax',
            'class' => NebraskaIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Nebraska Unemployment Tax',
            'class' => NebraskaUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Nebraska')->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $income_tax_id,
            'work_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);

        DB::table('tax_areas')->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }

    public function down(): void
    {
        $tax_id = DB::table('taxes')->where('class', NebraskaIncome::class)->id;
        $unemployment_id = DB::table('taxes')->where('class', NebraskaUnemployment::class)->id;

        DB::table('tax_areas')->where('tax_id', $unemployment_id)->delete();
        DB::table('tax_areas')->where('tax_id', $tax_id)->delete();

        DB::table('taxes')->where('id', $unemployment_id)->delete();
        DB::table('taxes')->where('id', $tax_id)->delete();

        Schema::drop('nebraska_income_tax_information');
    }
}
