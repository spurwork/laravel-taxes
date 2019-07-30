<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Oxford\Oxford;
use Carbon\Carbon;
use TestCase;

class OxfordTest extends TestCase
{
    public function testOxford()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.oxford'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.oxford'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Oxford::class));
    }
}
