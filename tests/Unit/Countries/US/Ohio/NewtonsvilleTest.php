<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Newtonsville\Newtonsville;
use Carbon\Carbon;
use TestCase;

class NewtonsvilleTest extends TestCase
{
    public function testNewtonsville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.newtonsville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.newtonsville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Newtonsville::class));
    }
}
