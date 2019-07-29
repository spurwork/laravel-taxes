<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewLexington\NewLexington;
use Carbon\Carbon;
use TestCase;

class NewLexingtonTest extends TestCase
{
    public function testNewLexington()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_lexington'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_lexington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NewLexington::class));
    }
}
