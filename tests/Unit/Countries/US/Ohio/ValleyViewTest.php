<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\ValleyView\ValleyView;
use Carbon\Carbon;
use TestCase;

class ValleyViewTest extends TestCase
{
    public function testValleyView()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.valley_view'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.valley_view'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(ValleyView::class));
    }
}
