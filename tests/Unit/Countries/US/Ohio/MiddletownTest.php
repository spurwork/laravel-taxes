<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Middletown\Middletown;
use Carbon\Carbon;
use TestCase;

class MiddletownTest extends TestCase
{
    public function testMiddletown()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.middletown'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.middletown'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(Middletown::class));
    }
}
