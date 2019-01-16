<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsIncome;

use Appleton\Taxes\Models\Countries\US\Massachusetts\MassachusettsIncomeTaxInformation;
use Carbon\Carbon;

class MassachusettsIncomeTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testMassachusettsIncome($date, $filing_status, $blind, $exemptions, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        MassachusettsIncomeTaxInformation::forUser($this->user)
            ->update([
                'blind' => $blind,
                'exemptions' => $exemptions,
                'filing_status' => $filing_status,
            ]);

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(MassachusettsIncome::class));
    }

    public function provideTestData()
    {
        return [
            '1' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_SINGLE,
                0,
                0,
                125,
                5.82,
            ],
            '2' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                0,
                125,
                3.49,
            ],
            '3' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                1,
                125,
                0.0,
            ],
        ];
    }
}
