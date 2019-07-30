<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Franklin\Franklin;
use Carbon\Carbon;
use TestCase;

class FranklinTest extends TestCase
{
    public function testFranklin()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.franklin'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.franklin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Franklin::class));
    }
}
