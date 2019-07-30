<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Reading\Reading;
use Carbon\Carbon;
use TestCase;

class ReadingTest extends TestCase
{
    public function testReading()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.reading'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.reading'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Reading::class));
    }
}
