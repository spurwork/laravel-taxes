<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Portage\Portage;
use Carbon\Carbon;
use TestCase;

class PortageTest extends TestCase
{
    public function testPortage()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.portage'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.portage'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Portage::class));
    }
}
