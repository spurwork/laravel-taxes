<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\MartinCounty\MartinCounty;
use Carbon\Carbon;
use TestCase;

class MartinCountyTest extends TestCase
{
    public function testMartinCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.martin_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.martin_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MartinCounty::class));
    }
}