<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Niles\Niles;
use Carbon\Carbon;
use TestCase;

class NilesTest extends TestCase
{
    public function testNiles()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.niles'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.niles'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Niles::class));
    }
}
