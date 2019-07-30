<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\UniversityHeights\UniversityHeights;
use Carbon\Carbon;
use TestCase;

class UniversityHeightsTest extends TestCase
{
    public function testUniversityHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.university_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.university_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.50, $results->getTax(UniversityHeights::class));
    }
}
