<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\MacedoniaNorthfieldCenter\MacedoniaNorthfieldCenter;
use Carbon\Carbon;
use TestCase;

class MacedoniaNorthfieldCenterTest extends TestCase
{
    public function testMacedoniaNorthfieldCenter()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([MacedoniaNorthfieldCenter::class]);
        });

        $this->assertSame(7.5, $results->getTax(MacedoniaNorthfieldCenter::class));
    }
}
