<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\McKeeCity\McKeeCity;
use Carbon\Carbon;
use TestCase;

class McKeeCityTest extends TestCase
{
    public function testMcKeeCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.mckee_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.mckee_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(McKeeCity::class));
    }
}
