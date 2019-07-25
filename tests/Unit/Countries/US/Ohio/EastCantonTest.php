<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\EastCanton\EastCanton;
use Carbon\Carbon;
use TestCase;

class EastCantonTest extends TestCase
{
    public function testEastCanton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.east_canton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.east_canton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(EastCanton::class));
    }
}
