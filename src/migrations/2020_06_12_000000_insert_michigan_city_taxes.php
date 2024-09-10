<?php

use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private const CLASSES = [
        'Albion City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\AlbionTax\AlbionTax::class,
        'Battle Creek City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\BattleCreekTax\BattleCreekTax::class,
        'Benton Harbor City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\BentonHarborTax\BentonHarborTax::class,
        'Big Rapids City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\BigRapidsTax\BigRapidsTax::class,
        'Detroit City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\DetroitTax\DetroitTax::class,
        'East Lansing City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\EastLansingTax\EastLansingTax::class,
        'Flint City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\FlintTax\FlintTax::class,
        'Grand Rapids City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\GrandRapidsTax\GrandRapidsTax::class,
        'Grayling City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\GraylingTax\GraylingTax::class,
        'Hamtramck City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\HamtramckTax\HamtramckTax::class,
        'Highland Park City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\HighlandParkTax\HighlandParkTax::class,
        'Hudson City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\HudsonTax\HudsonTax::class,
        'Ionia City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\IoniaTax\IoniaTax::class,
        'Jackson City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\JacksonTax\JacksonTax::class,
        'Lansing City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\LansingTax\LansingTax::class,
        'Lapeer City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\LapeerTax\LapeerTax::class,
        'Muskegon City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MuskegonTax\MuskegonTax::class,
        'Muskegon Heights City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MuskegonHeightsTax\MuskegonHeightsTax::class,
        'Pontiac City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\PontiacTax\PontiacTax::class,
        'Port Huron City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\PortHuronTax\PortHuronTax::class,
        'Portland City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\PortlandTax\PortlandTax::class,
        'Saginaw City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\SaginawTax\SaginawTax::class,
        'Springfield City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\SpringfieldTax\SpringfieldTax::class,
        'Walker City Tax' => \Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\WalkerTax\WalkerTax::class,
    ];

    public function up()
    {
        $id = DB::table('governmental_unit_areas')->where('name', 'Michigan')->first()->id;

        foreach (self::CLASSES as $name => $class) {
            $tax_id = DB::table('taxes')->insertGetId([
                'name' => $name,
                'class' => $class,
            ]);

            DB::table('tax_areas')->insert([[
                'tax_id' => $tax_id,
                'home_governmental_unit_area_id' => $id,
                'work_governmental_unit_area_id' => $id,
                'based' => TaxArea::BASED_ON_BOTH_LOCATIONS,
            ]]);
        }
    }
};
