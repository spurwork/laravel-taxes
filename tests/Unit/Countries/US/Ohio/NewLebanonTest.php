<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewLebanon\NewLebanon;
use Carbon\Carbon;
use TestCase;

class NewLebanonTest extends TestCase
{
    public function testNewLebanon()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_lebanon'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_lebanon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NewLebanon::class));
    }
}
