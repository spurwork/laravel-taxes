<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Forest\Forest;
use Carbon\Carbon;
use TestCase;

class ForestTest extends TestCase
{
    public function testForest()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.forest'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.forest'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(Forest::class));
    }
}
