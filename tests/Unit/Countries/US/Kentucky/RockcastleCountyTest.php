<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\RockcastleCounty\RockcastleCounty;
use Carbon\Carbon;
use TestCase;

class RockcastleCountyTest extends TestCase
{
    public function testRockcastleCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.rockcastle_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.rockcastle_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(RockcastleCounty::class));
    }
}
