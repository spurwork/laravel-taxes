<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Millersport\Millersport;
use Carbon\Carbon;
use TestCase;

class MillersportTest extends TestCase
{
    public function testMillersport()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.millersport'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.millersport'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Millersport::class));
    }
}
