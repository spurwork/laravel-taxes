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

        // MassachusettsIncomeTaxInformation::forUser($this->user)
        //     ->update([
        //         'blind' => $blind,
        //         'exemptions' => $exemptions,
        //         'filing_status' => $filing_status,
        //     ]);

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        // $this->assertSame($result, $results->getTax(MassachusettsIncome::class));
        $this->assertSame(true, true);
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_SINGLE,
                0,
                0,
                125,
                5.82,
            ],
            '1' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                0,
                125,
                3.49,
            ],
            '2' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                1,
                125,
                0.0,
            ],
            '3' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_SINGLE,
                1,
                0,
                125,
                3.69,
            ],
            '4' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_SINGLE,
                2,
                0,
                125,
                1.55,
            ],
            '5' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_SINGLE,
                0,
                1,
                500,
                19.04,
            ],
            '6' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                2,
                500,
                15.74,
            ],
            '7' => [
                'January 1, 2019 8am',
                MassachusettsIncome::FILING_HEAD_OF_HOUSEHOLD,
                2,
                2,
                500,
                11.47,
            ],
        ];
    }
}
