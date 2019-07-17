<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\UnionCity\UnionCity;
use Carbon\Carbon;
use TestCase;

class UnionCityTest extends TestCase
{
    public function testUnionCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.union_city'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.union_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(UnionCity::class));
    }
}
