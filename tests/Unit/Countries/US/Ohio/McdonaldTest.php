<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Mcdonald\Mcdonald;
use Carbon\Carbon;
use TestCase;

class McdonaldTest extends TestCase
{
    public function testMcdonald()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mcdonald'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mcdonald'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Mcdonald::class));
    }
}
