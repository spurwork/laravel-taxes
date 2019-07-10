<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\HopkinsvilleCity\HopkinsvilleCity;
use Carbon\Carbon;
use TestCase;

class HopkinsvilleCityTest extends TestCase
{
    public function testHopkinsvilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.hopkinsville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.hopkinsville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.85, $results->getTax(HopkinsvilleCity::class));
    }
}
