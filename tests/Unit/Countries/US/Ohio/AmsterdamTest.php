<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Amsterdam\Amsterdam;
use Carbon\Carbon;
use TestCase;

class AmsterdamTest extends TestCase
{
    public function testAmsterdam()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.amsterdam'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.amsterdam'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Amsterdam::class));
    }
}
