<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\MilfordIV\MilfordIV;
use Carbon\Carbon;
use TestCase;

class MilfordIVTest extends TestCase
{
    public function testMilfordIV()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([MilfordIV::class]);
        });

        $this->assertSame(3.0, $results->getTax(MilfordIV::class));
    }
}
