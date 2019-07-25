<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Camden\Camden;
use Carbon\Carbon;
use TestCase;

class CamdenTest extends TestCase
{
    public function testCamden()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.camden'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.camden'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Camden::class));
    }
}
