<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\KentFranklin\KentFranklin;
use Carbon\Carbon;
use TestCase;

class KentFranklinTest extends TestCase
{
    public function testKentFranklin()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([KentFranklin::class]);
        });

        $this->assertSame(6.0, $results->getTax(KentFranklin::class));
    }
}
