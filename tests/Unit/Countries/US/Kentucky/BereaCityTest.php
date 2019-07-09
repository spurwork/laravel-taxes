<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\BereaCity\BereaCity;
use Carbon\Carbon;
use TestCase;

class BereaCityTest extends TestCase
{
    public function testBereaCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.berea_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.berea_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(BereaCity::class));
    }
}
