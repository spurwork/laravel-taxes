<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Newark\Newark;
use Carbon\Carbon;
use TestCase;

class NewarkTest extends TestCase
{
    public function testNewark()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.newark'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.newark'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(Newark::class));
    }
}
