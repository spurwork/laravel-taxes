<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewRichmond\NewRichmond;
use Carbon\Carbon;
use TestCase;

class NewRichmondTest extends TestCase
{
    public function testNewRichmond()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_richmond'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_richmond'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NewRichmond::class));
    }
}
