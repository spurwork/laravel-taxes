<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Geneva\Geneva;
use Carbon\Carbon;
use TestCase;

class GenevaTest extends TestCase
{
    public function testGeneva()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.geneva'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.geneva'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Geneva::class));
    }
}
