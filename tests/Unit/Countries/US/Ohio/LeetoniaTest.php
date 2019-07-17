<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Leetonia\Leetonia;
use Carbon\Carbon;
use TestCase;

class LeetoniaTest extends TestCase
{
    public function testLeetonia()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.leetonia'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.leetonia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Leetonia::class));
    }
}
