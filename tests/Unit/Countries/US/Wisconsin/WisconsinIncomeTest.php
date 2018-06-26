<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome;

use Carbon\Carbon;

class WisconsinIncomeTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testWisconsinIncome()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(1000);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(56.87, $results->getTax(WisconsinIncome::class));
    }
    
}
