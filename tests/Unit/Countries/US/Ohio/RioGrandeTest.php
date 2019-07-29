<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\RioGrande\RioGrande;
use Carbon\Carbon;
use TestCase;

class RioGrandeTest extends TestCase
{
    public function testRioGrande()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.rio_grande'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.rio_grande'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(RioGrande::class));
    }
}
