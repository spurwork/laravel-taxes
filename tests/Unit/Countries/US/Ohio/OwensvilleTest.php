<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Owensville\Owensville;
use Carbon\Carbon;
use TestCase;

class OwensvilleTest extends TestCase
{
    public function testOwensville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.owensville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.owensville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Owensville::class));
    }
}
