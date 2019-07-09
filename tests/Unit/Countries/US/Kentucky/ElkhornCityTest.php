<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\ElkhornCity\ElkhornCity;
use Carbon\Carbon;
use TestCase;

class ElkhornCityTest extends TestCase
{
    public function testElkhornCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.elkhorn_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.elkhorn_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(ElkhornCity::class));
    }
}
