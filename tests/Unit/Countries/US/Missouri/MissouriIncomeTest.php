<?php

namespace Appleton\Taxes\Unit\Countries\US\Missouri\MissouriIncome;

use Appleton\Taxes\Countries\US\Missouri\MissouriIncome\MissouriIncome;
use Appleton\Taxes\Models\Countries\US\Missouri\MissouriIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class MissouriIncomeTest extends TestCase
{
    /**
    * @dataProvider provideTestData
    */
    public function testMissouriIncome($date, $filing_status, $exempt, $allowances, $additional_withholding, $earnings, $result)
    {
        MissouriIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => $additional_withholding,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
            'allowances' => $allowances,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.missouri'));
            $taxes->setWorkLocation($this->getLocation('us.missouri'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(MissouriIncome::class));
    }

    public function provideTestData()
    {
        // date
        // filing status
        // exempt
        // allowances
        // additional_withholding
        // earnings
        // results
        return [
            // exempt, should be 0
            '0' => [
                'January 1, 2019 8am',
                MissouriIncome::FILING_SINGLE,
                true,
                0,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                MissouriIncome::FILING_MARRIED_FILING_SEPARATE,
                false,
                0,
                0,
                600,
                16,
            ],
            '2' => [
                'January 1, 2019 8am',
                MissouriIncome::FILING_MARRIED_BOTH_SPOUSES_EMPLOYED,
                false,
                0,
                0,
                100,
                null,
            ],
            '3' => [
                'January 1, 2019 8am',
                MissouriIncome::FILING_MARRIED_BOTH_SPOUSES_EMPLOYED,
                false,
                0,
                0,
                700,
                22,
            ],
            '4' => [
                'January 1, 2019 8am',
                MissouriIncome::FILING_MARRIED_ONE_SPOUSE_EMPLOYED,
                false,
                0,
                0,
                900,
                20,
            ],
            '5' => [
                'January 1, 2019 8am',
                MissouriIncome::FILING_MARRIED_ONE_SPOUSE_EMPLOYED,
                false,
                0,
                0,
                1000,
                25,
            ],
            '6' => [
                'January 1, 2019 8am',
                MissouriIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                0,
                0,
                250,
                null,
            ],
            '7' => [
                'January 1, 2019 8am',
                MissouriIncome::FILING_MARRIED_ONE_SPOUSE_EMPLOYED,
                false,
                0,
                0,
                961.54,
                23,
            ],
        ];
    }
}
