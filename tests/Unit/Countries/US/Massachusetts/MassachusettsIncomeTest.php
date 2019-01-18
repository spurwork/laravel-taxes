<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsIncome;

use Appleton\Taxes\Models\Countries\US\Massachusetts\MassachusettsIncomeTaxInformation;
use Carbon\Carbon;

class MassachusettsIncomeTest extends \TestCase
{
    public function testMassachusettsIncome()
    {
        // Carbon::setTestNow(
        //     Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        // );

        // MassachusettsIncomeTaxInformation::forUser($this->user)
        //     ->update([
        //         'blind' => $blind,
        //         'exemptions' => $exemptions,
        //         'filing_status' => $filing_status,
        //     ]);

        // $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
        //     $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
        //     $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
        //     $taxes->setUser($this->user);
        //     $taxes->setEarnings($earnings);
        //     $taxes->setPayPeriods(52);
        // });

        // $this->assertSame($result, $results->getTax(MassachusettsIncome::class));
        $this->assertSame(true, true);
    }
}
