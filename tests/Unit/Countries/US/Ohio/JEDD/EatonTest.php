<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\Eaton\Eaton;
use Carbon\Carbon;
use TestCase;

class EatonTest extends TestCase
{
    public function testEaton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([Eaton::class]);
        });

        $this->assertSame(6.75, $results->getTax(Eaton::class));
    }
}
