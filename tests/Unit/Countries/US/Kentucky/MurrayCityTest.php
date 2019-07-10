<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\MurrayCity\MurrayCity;
use Carbon\Carbon;
use TestCase;

class MurrayCityTest extends TestCase
{
    public function testMurrayCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.murray_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.murray_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MurrayCity::class));
    }
}
