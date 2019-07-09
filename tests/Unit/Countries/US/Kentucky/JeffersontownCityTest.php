<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\JeffersontownCity\JeffersontownCity;
use Carbon\Carbon;
use TestCase;

class JeffersontownCityTest extends TestCase
{
    public function testJeffersontownCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.jeffersontown_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.jeffersontown_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(JeffersontownCity::class));
    }
}
