<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\WaltonHillsSagamoreHills\WaltonHillsSagamoreHills;
use Carbon\Carbon;
use TestCase;

class WaltonHillsSagamoreHillsTest extends TestCase
{
    public function testWaltonHillsSagamoreHills()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([WaltonHillsSagamoreHills::class]);
        });

        $this->assertSame(7.5, $results->getTax(WaltonHillsSagamoreHills::class));
    }
}
