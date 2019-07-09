<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\NicholasvilleCity\NicholasvilleCity;
use Carbon\Carbon;
use TestCase;

class NicholasvilleCityTest extends TestCase
{
    public function testNicholasvilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.nicholasville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.nicholasville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(NicholasvilleCity::class));
    }
}
