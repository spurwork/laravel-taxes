<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\PaintsvilleCity\PaintsvilleCity;
use Carbon\Carbon;
use TestCase;

class PaintsvilleCityTest extends TestCase
{
    public function testPaintsvilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.paintsville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.paintsville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(PaintsvilleCity::class));
    }
}
