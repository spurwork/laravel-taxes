<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Clinton\Clinton;
use Carbon\Carbon;
use TestCase;

class ClintonTest extends TestCase
{
    public function testClinton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.clinton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.clinton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Clinton::class));
    }
}
