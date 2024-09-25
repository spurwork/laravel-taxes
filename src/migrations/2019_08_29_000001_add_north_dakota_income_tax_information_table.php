<?php
 use Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaIncome\NorthDakotaIncome;
use Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaUnemployment\NorthDakotaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('north_dakota_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exemptions')->default(0);
            $table->boolean('exempt')->default(false);
            $table->string('filing_status')->nullable();
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'North Dakota Income Tax',
            'class' => NorthDakotaIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'North Dakota Unemployment Tax',
            'class' => NorthDakotaUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'North Dakota')->first()->id;

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
        $tax_id = DB::table('taxes')->where('class', NorthDakotaIncome::class)->id;
        $unemployment_id = DB::table('taxes')->where('class', NorthDakotaUnemployment::class)->id;

        DB::table('tax_areas')->where('tax_id', $unemployment_id)->delete();
        DB::table('tax_areas')->where('tax_id', $tax_id)->delete();

        DB::table('taxes')->where('id', $unemployment_id)->delete();
        DB::table('taxes')->where('id', $tax_id)->delete();

        Schema::drop('north_dakota_income_tax_information');
    }
};
