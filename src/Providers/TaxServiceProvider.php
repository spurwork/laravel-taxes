<?php

namespace Appleton\Taxes\Providers;

use Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Appleton\Taxes\Classes\Payroll;

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
        \Appleton\Taxes\Countries\US\Alabama\BessemerOccupational\BessemerOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational\BirminghamOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\BrilliantOccupational\BrilliantOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\FairfieldOccupational\FairfieldOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\GadsdenOccupational\GadsdenOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\GlencoeOccupational\GlencoeOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\GoodwaterOccupational\GoodwaterOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\GuinOccupational\GuinOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\HackleburgOccupational\HackleburgOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\HaleyvilleOccupational\HaleyvilleOccupational::class,
        \Appleton\Taxes\Countries\US\Alabama\HamiltonOccupational\HamiltonOccupational::class,
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
        \Appleton\Taxes\Countries\US\Alabama\TuskegeeOccupational\TuskegeeOccupational::class,
        \Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome::class,
        \Appleton\Taxes\Countries\US\Colorado\ColoradoUnemployment\ColoradoUnemployment::class,
        \Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome::class,
        \Appleton\Taxes\Countries\US\Georgia\GeorgiaUnemployment\GeorgiaUnemployment::class,
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
            \Appleton\Taxes\Countries\US\FederalUnemployment\StateUnemployment::class,
            \Appleton\Taxes\Countries\US\FederalUnemployment\BaseStateUnemployment::class
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
