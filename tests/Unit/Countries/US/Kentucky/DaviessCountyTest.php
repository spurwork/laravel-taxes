<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\DaviessCounty\DaviessCounty;
use Carbon\Carbon;
use TestCase;

class DaviessCountyTest extends TestCase
{
    public function testDaviessCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.daviess_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.daviess_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.05, $results->getTax(DaviessCounty::class));
    }
}
