<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\BrownsvilleCity\BrownsvilleCity;
use Carbon\Carbon;
use TestCase;

class BrownsvilleCityTest extends TestCase
{
    public function testBrownsvilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.brownsville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.brownsville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(BrownsvilleCity::class));
    }
}
