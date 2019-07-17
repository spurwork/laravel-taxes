<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Coshocton\Coshocton;
use Carbon\Carbon;
use TestCase;

class CoshoctonTest extends TestCase
{
    public function testCoshocton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.coshocton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.coshocton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Coshocton::class));
    }
}
