<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthCollegeHill\NorthCollegeHill;
use Carbon\Carbon;
use TestCase;

class NorthCollegeHillTest extends TestCase
{
    public function testNorthCollegeHill()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_college_hill'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_college_hill'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(NorthCollegeHill::class));
    }
}
