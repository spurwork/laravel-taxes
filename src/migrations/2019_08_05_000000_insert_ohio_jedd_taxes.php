<?php

use Appleton\Taxes\Countries\US\Ohio\JEDD\Ashtabula\Ashtabula;
use Appleton\Taxes\Countries\US\Ohio\JEDD\BainbridgeSolon\BainbridgeSolon;
use Appleton\Taxes\Countries\US\Ohio\JEDD\BarnesvilleI\BarnesvilleI;
use Appleton\Taxes\Countries\US\Ohio\JEDD\BarnesvilleII\BarnesvilleII;
use Appleton\Taxes\Countries\US\Ohio\JEDD\BathAkronFairlawn\BathAkronFairlawn;
use Appleton\Taxes\Countries\US\Ohio\JEDD\BeachwoodEast\BeachwoodEast;
use Appleton\Taxes\Countries\US\Ohio\JEDD\BeachwoodWest\BeachwoodWest;
use Appleton\Taxes\Countries\US\Ohio\JEDD\BostonPeninsula\BostonPeninsula;
use Appleton\Taxes\Countries\US\Ohio\JEDD\BrimfieldKent\BrimfieldKent;
use Appleton\Taxes\Countries\US\Ohio\JEDD\BrimfieldTallmadge\BrimfieldTallmadge;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Butler\Butler;
use Appleton\Taxes\Countries\US\Ohio\JEDD\CirclevillePickaway\CirclevillePickaway;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Clayton\Clayton;
use Appleton\Taxes\Countries\US\Ohio\JEDD\CopleyAkron\CopleyAkron;
use Appleton\Taxes\Countries\US\Ohio\JEDD\CoventryAkron\CoventryAkron;
use Appleton\Taxes\Countries\US\Ohio\JEDD\CuyahogaFallsBoston\CuyahogaFallsBoston;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Eaton\Eaton;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Elyria\Elyria;
use Appleton\Taxes\Countries\US\Ohio\JEDD\EtnaReynoldsburgI\EtnaReynoldsburgI;
use Appleton\Taxes\Countries\US\Ohio\JEDD\EtnaReynoldsburgII\EtnaReynoldsburgII;
use Appleton\Taxes\Countries\US\Ohio\JEDD\EtnaReynoldsburgIII\EtnaReynoldsburgIII;
use Appleton\Taxes\Countries\US\Ohio\JEDD\HamiltonFairfieldI\HamiltonFairfieldI;
use Appleton\Taxes\Countries\US\Ohio\JEDD\HamiltonFairfieldII\HamiltonFairfieldII;
use Appleton\Taxes\Countries\US\Ohio\JEDD\HamiltonFairfieldIII\HamiltonFairfieldIII;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Harrison\Harrison;
use Appleton\Taxes\Countries\US\Ohio\JEDD\KentFranklin\KentFranklin;
use Appleton\Taxes\Countries\US\Ohio\JEDD\LibertyCenter\LibertyCenter;
use Appleton\Taxes\Countries\US\Ohio\JEDD\LibertyI\LibertyI;
use Appleton\Taxes\Countries\US\Ohio\JEDD\MacedoniaNorthfieldCenter\MacedoniaNorthfieldCenter;
use Appleton\Taxes\Countries\US\Ohio\JEDD\MedinaMontville\MedinaMontville;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Milford\Milford;
use Appleton\Taxes\Countries\US\Ohio\JEDD\MilfordII\MilfordII;
use Appleton\Taxes\Countries\US\Ohio\JEDD\MilfordIII\MilfordIII;
use Appleton\Taxes\Countries\US\Ohio\JEDD\MilfordIV\MilfordIV;
use Appleton\Taxes\Countries\US\Ohio\JEDD\NorthBaltimoreHenryVillage\NorthBaltimoreHenryVillage;
use Appleton\Taxes\Countries\US\Ohio\JEDD\NorthPickawayCounty\NorthPickawayCounty;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Olmsted\Olmsted;
use Appleton\Taxes\Countries\US\Ohio\JEDD\OrangeChagrinHighland\OrangeChagrinHighland;
use Appleton\Taxes\Countries\US\Ohio\JEDD\PainesvilleConcord\PainesvilleConcord;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Pataskala\Pataskala;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Perry\Perry;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Prairie\Prairie;
use Appleton\Taxes\Countries\US\Ohio\JEDD\RemindervilleTwinsburg\RemindervilleTwinsburg;
use Appleton\Taxes\Countries\US\Ohio\JEDD\RushUhrichsville\RushUhrichsville;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Scioto\Scioto;
use Appleton\Taxes\Countries\US\Ohio\JEDD\SpringfieldAkron\SpringfieldAkron;
use Appleton\Taxes\Countries\US\Ohio\JEDD\SpringfieldBeckley\SpringfieldBeckley;
use Appleton\Taxes\Countries\US\Ohio\JEDD\WaltonHillsSagamoreHills\WaltonHillsSagamoreHills;
use Appleton\Taxes\Countries\US\Ohio\JEDD\WestChesterI\WestChesterI;
use Appleton\Taxes\Countries\US\Ohio\JEDD\Williamsburg\Williamsburg;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertOhioJeddTaxes extends Migration
{
    protected $taxes = 'taxes';

    public function up()
    {
        DB::table($this->taxes)->insert([
            'name' => 'Ashtabula JEDD Tax',
            'class' => Ashtabula::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'BainbridgeSolon JEDD Tax',
            'class' => BainbridgeSolon::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'BarnesvilleI JEDD Tax',
            'class' => BarnesvilleI::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'BarnesvilleII JEDD Tax',
            'class' => BarnesvilleII::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'BathAkronFairlawn JEDD Tax',
            'class' => BathAkronFairlawn::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'BeachwoodEast JEDD Tax',
            'class' => BeachwoodEast::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'BeachwoodWest JEDD Tax',
            'class' => BeachwoodWest::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'BostonPeninsula JEDD Tax',
            'class' => BostonPeninsula::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'BrimfieldKent JEDD Tax',
            'class' => BrimfieldKent::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'BrimfieldTallmadge JEDD Tax',
            'class' => BrimfieldTallmadge::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Butlera JEDD Tax',
            'class' => Butler::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'CirclevillePickaway JEDD Tax',
            'class' => CirclevillePickaway::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Claytona JEDD Tax',
            'class' => Clayton::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'CopleyAkron JEDD Tax',
            'class' => CopleyAkron::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'CoventryAkron JEDD Tax',
            'class' => CoventryAkron::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'CuyahogaFallsBoston JEDD Tax',
            'class' => CuyahogaFallsBoston::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Eatona JEDD Tax',
            'class' => Eaton::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Elyriaa JEDD Tax',
            'class' => Elyria::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'EtnaReynoldsburgI JEDD Tax',
            'class' => EtnaReynoldsburgI::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'EtnaReynoldsburgII JEDD Tax',
            'class' => EtnaReynoldsburgII::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'EtnaReynoldsburgIII JEDD Tax',
            'class' => EtnaReynoldsburgIII::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'HamiltonFairfieldI JEDD Tax',
            'class' => HamiltonFairfieldI::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'HamiltonFairfieldII JEDD Tax',
            'class' => HamiltonFairfieldII::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'HamiltonFairfieldIII JEDD Tax',
            'class' => HamiltonFairfieldIII::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Harrisona JEDD Tax',
            'class' => Harrison::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'KentFranklin JEDD Tax',
            'class' => KentFranklin::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'LibertyCenter JEDD Tax',
            'class' => LibertyCenter::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'LibertyIa JEDD Tax',
            'class' => LibertyI::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'MacedoniaNorthfieldCenter JEDD Tax',
            'class' => MacedoniaNorthfieldCenter::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'MedinaMontville JEDD Tax',
            'class' => MedinaMontville::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Milforda JEDD Tax',
            'class' => Milford::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'MilfordII JEDD Tax',
            'class' => MilfordII::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'MilfordIII JEDD Tax',
            'class' => MilfordIII::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'MilfordIV JEDD Tax',
            'class' => MilfordIV::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'NorthBaltimoreHenryVillage JEDD Tax',
            'class' => NorthBaltimoreHenryVillage::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'NorthPickawayCounty JEDD Tax',
            'class' => NorthPickawayCounty::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Olmsteda JEDD Tax',
            'class' => Olmsted::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'OrangeChagrinHighland JEDD Tax',
            'class' => OrangeChagrinHighland::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'PainesvilleConcord JEDD Tax',
            'class' => PainesvilleConcord::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Pataskala JEDD Tax',
            'class' => Pataskala::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Perrya JEDD Tax',
            'class' => Perry::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Prairiea JEDD Tax',
            'class' => Prairie::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'RemindervilleTwinsburg JEDD Tax',
            'class' => RemindervilleTwinsburg::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'RushUhrichsville JEDD Tax',
            'class' => RushUhrichsville::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Sciotoa JEDD Tax',
            'class' => Scioto::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'SpringfieldAkron JEDD Tax',
            'class' => SpringfieldAkron::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'SpringfieldBeckley JEDD Tax',
            'class' => SpringfieldBeckley::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'WaltonHillsSagamoreHills JEDD Tax',
            'class' => WaltonHillsSagamoreHills::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'WestChesterI JEDD Tax',
            'class' => WestChesterI::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Williamsburg JEDD Tax',
            'class' => Williamsburg::class,
        ]);
    }
}
