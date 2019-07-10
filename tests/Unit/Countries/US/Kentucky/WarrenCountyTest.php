<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\WarrenCounty\WarrenCounty;
use Carbon\Carbon;
use TestCase;

class WarrenCountyTest extends TestCase
{
    public function testWarrenCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.warren_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.warren_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(WarrenCounty::class));
    }
}
