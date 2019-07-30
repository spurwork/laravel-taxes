<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Ripley\Ripley;
use Carbon\Carbon;
use TestCase;

class RipleyTest extends TestCase
{
    public function testRipley()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.ripley'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.ripley'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Ripley::class));
    }
}
