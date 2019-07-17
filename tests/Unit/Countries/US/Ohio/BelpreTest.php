<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Belpre\Belpre;
use Carbon\Carbon;
use TestCase;

class BelpreTest extends TestCase
{
    public function testBelpre()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.belpre'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.belpre'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Belpre::class));
    }
}
