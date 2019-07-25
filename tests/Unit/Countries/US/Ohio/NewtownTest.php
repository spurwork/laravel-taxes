<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Newtown\Newtown;
use Carbon\Carbon;
use TestCase;

class NewtownTest extends TestCase
{
    public function testNewtown()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.newtown'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.newtown'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Newtown::class));
    }
}
