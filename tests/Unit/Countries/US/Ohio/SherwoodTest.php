<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Sherwood\Sherwood;
use Carbon\Carbon;
use TestCase;

class SherwoodTest extends TestCase
{
    public function testSherwood()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.sherwood'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.sherwood'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Sherwood::class));
    }
}
