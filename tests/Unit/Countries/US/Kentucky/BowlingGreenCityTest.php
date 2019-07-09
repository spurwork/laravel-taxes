<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\BowlingGreenCity\BowlingGreenCity;
use Carbon\Carbon;
use TestCase;

class BowlingGreenCityTest extends TestCase
{
    public function testBowlingGreenCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.bowling_green_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.bowling_green_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.55, $results->getTax(BowlingGreenCity::class));
    }
}
