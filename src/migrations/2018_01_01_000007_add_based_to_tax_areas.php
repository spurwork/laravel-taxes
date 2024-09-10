<?php

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment;
use Appleton\Taxes\Countries\US\Alabama\AttallaOccupational\AttallaOccupational;
use Appleton\Taxes\Countries\US\Alabama\AuburnOccupational\AuburnOccupational;
use Appleton\Taxes\Countries\US\Alabama\BearCreekOccupational\BearCreekOccupational;
use Appleton\Taxes\Countries\US\Alabama\BessemerOccupational\BessemerOccupational;
use Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational\BirminghamOccupational;
use Appleton\Taxes\Countries\US\Alabama\BrilliantOccupational\BrilliantOccupational;
use Appleton\Taxes\Countries\US\Alabama\FairfieldOccupational\FairfieldOccupational;
use Appleton\Taxes\Countries\US\Alabama\GadsdenOccupational\GadsdenOccupational;
use Appleton\Taxes\Countries\US\Alabama\GlencoeOccupational\GlencoeOccupational;
use Appleton\Taxes\Countries\US\Alabama\GoodwaterOccupational\GoodwaterOccupational;
use Appleton\Taxes\Countries\US\Alabama\GuinOccupational\GuinOccupational;
use Appleton\Taxes\Countries\US\Alabama\HackleburgOccupational\HackleburgOccupational;
use Appleton\Taxes\Countries\US\Alabama\HaleyvilleOccupational\HaleyvilleOccupational;
use Appleton\Taxes\Countries\US\Alabama\HamiltonOccupational\HamiltonOccupational;
use Appleton\Taxes\Countries\US\Alabama\LeedsOccupational\LeedsOccupational;
use Appleton\Taxes\Countries\US\Alabama\LynnOccupational\LynnOccupational;
use Appleton\Taxes\Countries\US\Alabama\MaconCountyOccupational\MaconCountyOccupational;
use Appleton\Taxes\Countries\US\Alabama\MidfieldOccupational\MidfieldOccupational;
use Appleton\Taxes\Countries\US\Alabama\MossesOccupational\MossesOccupational;
use Appleton\Taxes\Countries\US\Alabama\OpelikaOccupational\OpelikaOccupational;
use Appleton\Taxes\Countries\US\Alabama\RainbowCityOccupational\RainbowCityOccupational;
use Appleton\Taxes\Countries\US\Alabama\RedBayOccupational\RedBayOccupational;
use Appleton\Taxes\Countries\US\Alabama\ShorterOccupational\ShorterOccupational;
use Appleton\Taxes\Countries\US\Alabama\SouthsideOccupational\SouthsideOccupational;
use Appleton\Taxes\Countries\US\Alabama\SulligentOccupational\SulligentOccupational;
use Appleton\Taxes\Countries\US\Alabama\TuskegeeOccupational\TuskegeeOccupational;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaUnemployment\GeorgiaUnemployment;
use Appleton\Taxes\Countries\US\Medicare\Medicare;
use Appleton\Taxes\Countries\US\Medicare\MedicareEmployer;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $tax_areas = 'tax_areas';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->string('based')->default('');
        });

        DB::table($this->tax_areas)
            ->whereIn('tax', [
                AlabamaUnemployment::class,
                GeorgiaUnemployment::class,
            ])
            ->update(['based' => TaxArea::BASED_ON_HOME_LOCATION]);

        DB::table($this->tax_areas)
            ->whereIn('tax', [
                FederalIncome::class,
                FederalUnemployment::class,
                Medicare::class,
                MedicareEmployer::class,
                SocialSecurity::class,
                SocialSecurityEmployer::class,
                AlabamaIncome::class,
                AttallaOccupational::class,
                AuburnOccupational::class,
                BearCreekOccupational::class,
                BessemerOccupational::class,
                BirminghamOccupational::class,
                BrilliantOccupational::class,
                FairfieldOccupational::class,
                GadsdenOccupational::class,
                GlencoeOccupational::class,
                GoodwaterOccupational::class,
                GuinOccupational::class,
                HackleburgOccupational::class,
                HaleyvilleOccupational::class,
                HamiltonOccupational::class,
                LeedsOccupational::class,
                LynnOccupational::class,
                MaconCountyOccupational::class,
                MidfieldOccupational::class,
                MossesOccupational::class,
                OpelikaOccupational::class,
                RainbowCityOccupational::class,
                RedBayOccupational::class,
                ShorterOccupational::class,
                SouthsideOccupational::class,
                SulligentOccupational::class,
                TuskegeeOccupational::class,
                GeorgiaIncome::class,
            ])
            ->update(['based' => TaxArea::BASED_ON_WORK_LOCATION]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tax_areas, function (Blueprint $table) {
            $table->dropColumn('based');
        });
    }
};
