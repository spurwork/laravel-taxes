<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewAlbany\NewAlbany;
use Carbon\Carbon;
use TestCase;

class NewAlbanyTest extends TestCase
{
    public function testNewAlbany()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_albany'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_albany'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(NewAlbany::class));
    }
}
