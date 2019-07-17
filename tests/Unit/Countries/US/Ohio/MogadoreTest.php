<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Mogadore\Mogadore;
use Carbon\Carbon;
use TestCase;

class MogadoreTest extends TestCase
{
    public function testMogadore()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mogadore'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mogadore'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(Mogadore::class));
    }
}
