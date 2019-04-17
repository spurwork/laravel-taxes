<?php

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Appleton\Taxes\Countries\US\Maryland\MarylandUnemployment\MarylandUnemployment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateTaxNames extends Migration
{
    public function up(): void
    {
        DB::table('taxes')
            ->where('class', 'like', 'Appleton\\\\Taxes\\\\Countries\\\\US\\\\Alabama\\\\%')
            ->where('class', '!=', MarylandIncome::class)
            ->where('class', '!=', MarylandUnemployment::class)
            ->orderBy('id')
            ->each(static function ($tax) {
                $new_name = preg_replace('/(.*) Occupational Tax/', '$1 Alabama Occupational Tax', $tax->name);
                if ($tax->name === $new_name) {
                    return;
                }

                DB::table('taxes')->where('id', $tax->id)->update(['name' => $new_name]);
            });

        DB::table('taxes')
            ->where('class', 'like', 'Appleton\\\\Taxes\\\\Countries\\\\US\\\\Maryland\\\\%')
            ->where('class', '!=', AlabamaIncome::class)
            ->where('class', '!=', AlabamaUnemployment::class)
            ->orderBy('id')
            ->each(static function ($tax) {
                $new_name = preg_replace('/(.*) Tax/', '$1 Maryland Tax', $tax->name);
                if ($tax->name === $new_name) {
                    return;
                }

                DB::table('taxes')->where('id', $tax->id)->update(['name' => $new_name]);
            });

        DB::table('taxes')->where('name', '=', 'Yonkers Tax')->update(['name' => 'Yonkers New York Tax']);
        DB::table('taxes')->where('name', '=', 'New York City Tax')->update(['name' => 'New York City New York Tax']);
    }

    public function down(): void
    {
        DB::table('taxes')->where('name', '=', 'Yonkers New York Tax')->update(['name' => 'Yonkers Tax']);
        DB::table('taxes')->where('name', '=', 'New York City New York Tax')->update(['name' => 'New York City Tax']);

        DB::table('taxes')
            ->where('class', 'like', 'Appleton\\\\Taxes\\\\Countries\\\\US\\\\Maryland\\\\%')
            ->where('class', '!=', AlabamaIncome::class)
            ->where('class', '!=', AlabamaUnemployment::class)
            ->orderBy('id')
            ->each(static function ($tax) {
                $new_name = preg_replace('/(.*) Maryland Tax/', '$1 Tax', $tax->name);
                if ($tax->name === $new_name) {
                    return;
                }

                DB::table('taxes')->where('id', $tax->id)->update(['name' => $new_name]);
            });

        DB::table('taxes')
            ->where('class', 'like', 'Appleton\\\\Taxes\\\\Countries\\\\US\\\\Alabama\\\\%')
            ->where('class', '!=', MarylandIncome::class)
            ->where('class', '!=', MarylandUnemployment::class)
            ->orderBy('id')
            ->each(static function ($tax) {
                $new_name = preg_replace('/(.*) Alabama Occupational Tax/', '$1 Occupational Tax', $tax->name);
                if ($tax->name === $new_name) {
                    return;
                }

                DB::table('taxes')->where('id', $tax->id)->update(['name' => $new_name]);
            });
    }
}
