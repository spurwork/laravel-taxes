<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Harrod\Harrod;
use Carbon\Carbon;
use TestCase;

class HarrodTest extends TestCase
{
    public function testHarrod()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.harrod'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.harrod'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Harrod::class));
    }
}
