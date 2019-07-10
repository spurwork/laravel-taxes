<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\HickmanCity\HickmanCity;
use Carbon\Carbon;
use TestCase;

class HickmanCityTest extends TestCase
{
    public function testHickmanCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.hickman_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.hickman_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(HickmanCity::class));
    }
}
