<?php

namespace Appleton\Taxes\Providers;

use Appleton\Taxes\Classes\Payroll;
use Illuminate\Support\ServiceProvider;

class TaxInformationServiceProvider extends ServiceProvider
{
    protected $defer = true;

    protected $interfaces = [
        \Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\Arizona\ArizonaIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\Illinois\IllinoisIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\Massachusetts\MassachusettsIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation::class,
        \Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation::class,
    ];

    public function register()
    {
        foreach ($this->interfaces as $interface) {
            $this->app->bind($interface, function ($app) use ($interface) {
                if ($app->bound(Payroll::class)) {
                    $payroll = $app->make(Payroll::class);
                    if (is_null($payroll->user)) {
                        $tax_information = $interface::getDefault();
                    } else {
                        $tax_information = $interface::forUser($payroll->user)->first();
                        if (is_null($tax_information)) {
                            $tax_information = $interface::getDefault();
                        }
                    }
                } else {
                    $tax_information = $interface::getDefault();
                }
                return $tax_information;
            });
        }
    }

    public function provides()
    {
        return $this->interfaces;
    }
}
