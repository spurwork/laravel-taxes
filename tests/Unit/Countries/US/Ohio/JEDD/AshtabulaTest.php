<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\Ashtabula\Ashtabula;
use Carbon\Carbon;
use TestCase;

class AshtabulaTest extends TestCase
{
    public function testAshtabula()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([Ashtabula::class]);
        });

        $this->assertSame(5.40, $results->getTax(Ashtabula::class));
    }
}
