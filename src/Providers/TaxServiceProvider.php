<?php

namespace Appleton\Taxes\Providers;

use Appleton\Taxes\Classes\Payroll;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class TaxServiceProvider extends ServiceProvider
{
    protected $defer = true;

    protected $interfaces = [
        \Appleton\Taxes\Countries\US\FederalIncome\FederalIncome::class,
        \Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment::class,
        \Appleton\Taxes\Countries\US\Medicare\Medicare::class,
        \Appleton\Taxes\Countries\US\Medicare\MedicareEmployer::class,
        \Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity::class,
        \Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer::class,
        \Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome::class,
        \Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment::class,
        \Appleton\Taxes\Countries\US\Alabama\AttallaOccupational\AttallaOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\AuburnOccupational\AuburnOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\BearCreekOccupational\BearCreekOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\BeavertonOccupational\BeavertonOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\BessemerOccupational\BessemerOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational\BirminghamOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\BrilliantOccupational\BrilliantOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\FairfieldOccupational\FairfieldOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\FortDepositOccupational\FortDepositOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\GadsdenOccupational\GadsdenOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\GlencoeOccupational\GlencoeOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\GoodwaterOccupational\GoodwaterOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\GuinOccupational\GuinOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\HackleburgOccupational\HackleburgOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\HaleyvilleOccupational\HaleyvilleOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\HamiltonOccupational\HamiltonOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\HobsonCityOccupational\HobsonCityOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\IrondaleOccupational\IrondaleOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\LeedsOccupational\LeedsOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\LynnOccupational\LynnOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\MaconCountyOccupational\MaconCountyOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\MidfieldOccupational\MidfieldOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\MossesOccupational\MossesOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\OpelikaOccupational\OpelikaOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\RainbowCityOccupational\RainbowCityOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\RedBayOccupational\RedBayOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\ShorterOccupational\ShorterOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\SouthsideOccupational\SouthsideOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\SulligentOccupational\SulligentOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\TarrantOccupational\TarrantOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\TuskegeeOccupational\TuskegeeOccupational::class,
        \Appleton\Taxes\Countries\US\Arizona\ArizonaIncome\ArizonaIncome::class,
        \Appleton\Taxes\Countries\US\Arizona\ArizonaUnemployment\ArizonaUnemployment::class,
        \Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome::class,
        \Appleton\Taxes\Countries\US\Colorado\ColoradoUnemployment\ColoradoUnemployment::class,
        \Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome::class,
        \Appleton\Taxes\Countries\US\Georgia\GeorgiaUnemployment\GeorgiaUnemployment::class,
        \Appleton\Taxes\Countries\US\Illinois\IllinoisIncome\IllinoisIncome::class,
        \Appleton\Taxes\Countries\US\Illinois\IllinoisUnemployment\IllinoisUnemployment::class,
        \Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\IndianaUnemployment\IndianaUnemployment::class,
        \Appleton\Taxes\Countries\US\Indiana\AdamsIncome\AdamsIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\AllenIncome\AllenIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\BartholomewIncome\BartholomewIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\BentonIncome\BentonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\BlackfordIncome\BlackfordIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\BooneIncome\BooneIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\BrownIncome\BrownIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\CarrollIncome\CarrollIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\CassIncome\CassIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\ClarkIncome\ClarkIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\ClayIncome\ClayIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\ClintonIncome\ClintonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\CrawfordIncome\CrawfordIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\DaviessIncome\DaviessIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\DearbornIncome\DearbornIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\DecaturIncome\DecaturIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\DeKalbIncome\DeKalbIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\DelawareIncome\DelawareIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\DuboisIncome\DuboisIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\ElkhartIncome\ElkhartIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\FayetteIncome\FayetteIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\FloydIncome\FloydIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\FountainIncome\FountainIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\FranklinIncome\FranklinIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\FultonIncome\FultonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\GibsonIncome\GibsonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\GrantIncome\GrantIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\GreeneIncome\GreeneIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\HamiltonIncome\HamiltonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\HancockIncome\HancockIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\HarrisonIncome\HarrisonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\HendricksIncome\HendricksIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\HenryIncome\HenryIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\HowardIncome\HowardIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\HuntingtonIncome\HuntingtonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\JacksonIncome\JacksonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\JasperIncome\JasperIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\JayIncome\JayIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\JeffersonIncome\JeffersonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\JenningsIncome\JenningsIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\JohnsonIncome\JohnsonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\KnoxIncome\KnoxIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\KosciuskoIncome\KosciuskoIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\LaGrangeIncome\LaGrangeIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\LakeIncome\LakeIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\LaPorteIncome\LaPorteIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\LawrenceIncome\LawrenceIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\MadisonIncome\MadisonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\MarionIncome\MarionIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\MarshallIncome\MarshallIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\MartinIncome\MartinIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\MiamiIncome\MiamiIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\MonroeIncome\MonroeIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\MontgomeryIncome\MontgomeryIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\MorganIncome\MorganIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\NewtonIncome\NewtonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\NobleIncome\NobleIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\OhioIncome\OhioIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\OrangeIncome\OrangeIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\OwenIncome\OwenIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\ParkeIncome\ParkeIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\PerryIncome\PerryIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\PikeIncome\PikeIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\PorterIncome\PorterIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\PoseyIncome\PoseyIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\PulaskiIncome\PulaskiIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\PutnamIncome\PutnamIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\RandolphIncome\RandolphIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\RipleyIncome\RipleyIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\RushIncome\RushIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\ScottIncome\ScottIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\ShelbyIncome\ShelbyIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\SpencerIncome\SpencerIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\StarkeIncome\StarkeIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\SteubenIncome\SteubenIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\StJosephIncome\StJosephIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\SullivanIncome\SullivanIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\SwitzerlandIncome\SwitzerlandIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\TippecanoeIncome\TippecanoeIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\TiptonIncome\TiptonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\UnionIncome\UnionIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\VanderburghIncome\VanderburghIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\VermillionIncome\VermillionIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\VigoIncome\VigoIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\WabashIncome\WabashIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\WarrenIncome\WarrenIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\WarrickIncome\WarrickIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\WashingtonIncome\WashingtonIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\WayneIncome\WayneIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\WellsIncome\WellsIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\WhiteIncome\WhiteIncome::class,
        \Appleton\Taxes\Countries\US\Indiana\WhitleyIncome\WhitleyIncome::class,
        \Appleton\Taxes\Countries\US\Florida\FloridaUnemployment\FloridaUnemployment::class,
        \Appleton\Taxes\Countries\US\Tennessee\TennesseeUnemployment\TennesseeUnemployment::class,
        \Appleton\Taxes\Countries\US\Texas\TexasUnemployment\TexasUnemployment::class,
        \Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome\KentuckyIncome::class,
        \Appleton\Taxes\Countries\US\Kentucky\KentuckyUnemployment\KentuckyUnemployment::class,
        \Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome::class,
        \Appleton\Taxes\Countries\US\Maryland\MarylandUnemployment\MarylandUnemployment::class,
        \Appleton\Taxes\Countries\US\Maryland\Allegany\Allegany::class,
        \Appleton\Taxes\Countries\US\Maryland\AnneArundel\AnneArundel::class,
        \Appleton\Taxes\Countries\US\Maryland\Baltimore\Baltimore::class,
        \Appleton\Taxes\Countries\US\Maryland\BaltimoreCity\BaltimoreCity::class,
        \Appleton\Taxes\Countries\US\Maryland\Calvert\Calvert::class,
        \Appleton\Taxes\Countries\US\Maryland\Caroline\Caroline::class,
        \Appleton\Taxes\Countries\US\Maryland\Carroll\Carroll::class,
        \Appleton\Taxes\Countries\US\Maryland\Cecil\Cecil::class,
        \Appleton\Taxes\Countries\US\Maryland\Charles\Charles::class,
        \Appleton\Taxes\Countries\US\Maryland\Dorchester\Dorchester::class,
        \Appleton\Taxes\Countries\US\Maryland\Frederick\Frederick::class,
        \Appleton\Taxes\Countries\US\Maryland\Garrett\Garrett::class,
        \Appleton\Taxes\Countries\US\Maryland\Harford\Harford::class,
        \Appleton\Taxes\Countries\US\Maryland\Howard\Howard::class,
        \Appleton\Taxes\Countries\US\Maryland\Kent\Kent::class,
        \Appleton\Taxes\Countries\US\Maryland\Montgomery\Montgomery::class,
        \Appleton\Taxes\Countries\US\Maryland\PrinceGeorges\PrinceGeorges::class,
        \Appleton\Taxes\Countries\US\Maryland\QueenAnnes\QueenAnnes::class,
        \Appleton\Taxes\Countries\US\Maryland\StMarys\StMarys::class,
        \Appleton\Taxes\Countries\US\Maryland\Somerset\Somerset::class,
        \Appleton\Taxes\Countries\US\Maryland\Talbot\Talbot::class,
        \Appleton\Taxes\Countries\US\Maryland\Washington\Washington::class,
        \Appleton\Taxes\Countries\US\Maryland\Wicomico\Wicomico::class,
        \Appleton\Taxes\Countries\US\Maryland\Worcester\Worcester::class,
        \Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeave\MassachusettsFamilyMedicalLeave::class,
        \Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeaveEmployer\MassachusettsFamilyMedicalLeaveEmployer::class,
        \Appleton\Taxes\Countries\US\Massachusetts\MassachusettsIncome\MassachusettsIncome::class,
        \Appleton\Taxes\Countries\US\Massachusetts\MassachusettsWorkforceTrainingFund\MassachusettsWorkforceTrainingFund::class,
        \Appleton\Taxes\Countries\US\Massachusetts\MassachusettsUnemployment\MassachusettsUnemployment::class,
        \Appleton\Taxes\Countries\US\Michigan\MichiganIncome\MichiganIncome::class,
        \Appleton\Taxes\Countries\US\Michigan\MichiganUnemployment\MichiganUnemployment::class,
        \Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome::class,
        \Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment\NewMexicoUnemployment::class,
        \Appleton\Taxes\Countries\US\NewYork\NewYorkCity\NewYorkCity::class,
        \Appleton\Taxes\Countries\US\NewYork\NewYorkDisabilityInsurance\NewYorkDisabilityInsurance::class,
        \Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave\NewYorkFamilyMedicalLeave::class,
        \Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome::class,
        \Appleton\Taxes\Countries\US\NewYork\NewYorkMetropolitanCommuterTransportationMobility\NewYorkMetropolitanCommuterTransportationMobility::class,
        \Appleton\Taxes\Countries\US\NewYork\NewYorkUnemployment\NewYorkUnemployment::class,
        \Appleton\Taxes\Countries\US\NewYork\Yonkers\Yonkers::class,
        \Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome::class,
        \Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaUnemployment\NorthCarolinaUnemployment::class,
        \Appleton\Taxes\Countries\US\Virginia\VirginiaIncome\VirginiaIncome::class,
        \Appleton\Taxes\Countries\US\Virginia\VirginiaUnemployment\VirginiaUnemployment::class,
        \Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\WisconsinIncome::class,
        \Appleton\Taxes\Countries\US\Wisconsin\WisconsinUnemployment\WisconsinUnemployment::class,
    ];

    private function getImplementations($interface)
    {
        return array_reverse(array_map('basename', glob(dirname((new \ReflectionClass($interface))->getFileName()).'/V*', GLOB_ONLYDIR)));
    }

    private function resolveImplementation($interface, $date)
    {
        $basename = class_basename($interface);
        $namespace = substr($interface, 0, -strlen($basename) - 1);
        foreach ($this->getImplementations($interface) as $implementation) {
            if ($date->diffInDays(Carbon::createFromFormat('Ymd', substr($implementation, 1)), false) <= 0) {
                return $namespace.'\\'.$implementation.'\\'.$basename;
            }
        }
        throw new \Exception('The implementation could not be found.');
    }

    public function register()
    {
        $this->app->bind(
            \Appleton\Taxes\Classes\StateUnemployment::class,
            \Appleton\Taxes\Classes\BaseStateUnemployment::class
        );

        foreach ($this->interfaces as $interface) {
            $this->app->bind($interface, function ($app) use ($interface) {
                $payroll = $app->make(Payroll::class);
                $implementation = $this->resolveImplementation($interface, $payroll->date);

                return $app->make($implementation);
            });
        }
    }

    public function provides()
    {
        return $this->interfaces;
    }
}
