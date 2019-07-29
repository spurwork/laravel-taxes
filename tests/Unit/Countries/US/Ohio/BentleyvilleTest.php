<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Bentleyville\Bentleyville;
use Carbon\Carbon;
use TestCase;

class BentleyvilleTest extends TestCase
{
    public function testBentleyville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.bentleyville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.bentleyville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Bentleyville::class));
    }
}
