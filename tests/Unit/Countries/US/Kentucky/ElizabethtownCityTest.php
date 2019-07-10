<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\ElizabethtownCity\ElizabethtownCity;
use Carbon\Carbon;
use TestCase;

class ElizabethtownCityTest extends TestCase
{
    public function testElizabethtownCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.elizabethtown_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.elizabethtown_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.05, $results->getTax(ElizabethtownCity::class));
    }
}
