<?php

namespace Appleton\Taxes\Unit\Countries\US\NewJersey\NewJerseyIncome\V20190101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\NewJerseyIncome;
use Carbon\Carbon;

class NewJerseyIncomeTest extends \TestCase
{
    public function testNewJerseyIncome()
    {

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(52);
        });

//        $this->assertSame(2.06, $results->getTax(NewJerseyIncome::class));
    }
}