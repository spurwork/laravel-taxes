<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SouthVienna\SouthVienna;
use Carbon\Carbon;
use TestCase;

class SouthViennaTest extends TestCase
{
    public function testSouthVienna()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.south_vienna'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.south_vienna'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(SouthVienna::class));
    }
}
