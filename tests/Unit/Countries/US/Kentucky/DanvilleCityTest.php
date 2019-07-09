<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\DanvilleCity\DanvilleCity;
use Carbon\Carbon;
use TestCase;

class DanvilleCityTest extends TestCase
{
    public function testDanvilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.danville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.danville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.70, $results->getTax(DanvilleCity::class));
    }
}
