<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Bucyrus\Bucyrus;
use Carbon\Carbon;
use TestCase;

class BucyrusTest extends TestCase
{
    public function testBucyrus()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.bucyrus'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.bucyrus'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Bucyrus::class));
    }
}
