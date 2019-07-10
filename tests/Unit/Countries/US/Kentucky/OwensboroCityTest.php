<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\OwensboroCity\OwensboroCity;
use Carbon\Carbon;
use TestCase;

class OwensboroCityTest extends TestCase
{
    public function testOwensboroCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.owensboro_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.owensboro_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.34, $results->getTax(OwensboroCity::class));
    }
}
