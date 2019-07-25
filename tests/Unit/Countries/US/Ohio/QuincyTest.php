<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Quincy\Quincy;
use Carbon\Carbon;
use TestCase;

class QuincyTest extends TestCase
{
    public function testQuincy()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.quincy'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.quincy'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Quincy::class));
    }
}
