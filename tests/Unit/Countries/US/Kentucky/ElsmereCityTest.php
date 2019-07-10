<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\ElsmereCity\ElsmereCity;
use Carbon\Carbon;
use TestCase;

class ElsmereCityTest extends TestCase
{
    public function testElsmereCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.elsmere_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.elsmere_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(ElsmereCity::class));
    }
}
