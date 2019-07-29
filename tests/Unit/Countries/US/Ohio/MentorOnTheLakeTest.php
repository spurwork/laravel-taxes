<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MentorOnTheLake\MentorOnTheLake;
use Carbon\Carbon;
use TestCase;

class MentorOnTheLakeTest extends TestCase
{
    public function testMentorOnTheLake()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mentor_on_the_lake'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mentor_on_the_lake'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(MentorOnTheLake::class));
    }
}
