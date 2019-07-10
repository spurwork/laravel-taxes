<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\MaysvilleCity\MaysvilleCity;
use Carbon\Carbon;
use TestCase;

class MaysvilleCityTest extends TestCase
{
    public function testMaysvilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.maysville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.maysville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.97, $results->getTax(MaysvilleCity::class));
    }
}
