<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\PikevilleCity\PikevilleCity;
use Carbon\Carbon;
use TestCase;

class PikevilleCityTest extends TestCase
{
    public function testPikevilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.pikeville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.pikeville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(PikevilleCity::class));
    }
}
