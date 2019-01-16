<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsIncome;

use Appleton\Taxes\Models\Countries\US\Massachusetts\MassachusettsIncomeTaxInformation;
use Carbon\Carbon;

class MassachusettsIncomeTest extends \TestCase
{
    public function testMassachusettsIncome()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(125);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.82, $results->getTax(MassachusettsIncome::class));
    }
}
