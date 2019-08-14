<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\CaneyvilleCity\CaneyvilleCity;
use Carbon\Carbon;
use TestCase;

class CaneyvilleCityTest extends TestCase
{
    public function testCaneyvilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.caneyville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.caneyville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setDaysWorked(3);
        });

        $this->assertSame(2.00, $results->getTax(CaneyvilleCity::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.caneyville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.caneyville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setDaysWorked(4);
        });

        $this->assertSame(4.00, $results->getTax(CaneyvilleCity::class));
    }
}
