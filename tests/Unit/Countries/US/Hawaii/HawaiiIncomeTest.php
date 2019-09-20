<?php

namespace Appleton\Taxes\Unit\Countries\US\Hawaii\HawaiiIncome;

use Appleton\Taxes\Countries\US\Hawaii\HawaiiIncome\HawaiiIncome;
use Appleton\Taxes\Models\Countries\US\Hawaii\HawaiiIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class HawaiiIncomeTest extends TestCase
{
    /**
    * @dataProvider provideTestData
    */
    public function testHawaiiIncome($date, $filing_status, $exempt, $exemptions, $additional_withholding, $earnings, $result)
    {
        HawaiiIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => $additional_withholding,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
            'exemptions' => $exemptions,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.hawaii'));
            $taxes->setWorkLocation($this->getLocation('us.hawaii'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(HawaiiIncome::class));
    }

    public function provideTestData()
    {
        // date
        // filing status
        // exempt
        // exemptions
        // additional_withholding
        // earnings
        // results
        return [
            // exempt, should be 0
            '0' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_SINGLE,
                true,
                0,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_SINGLE,
                false,
                0,
                0,
                300,
                14.68,
            ],
            '2' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_SINGLE,
                false,
                2,
                0,
                500,
                25.63,
            ],
            '3' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_SINGLE,
                false,
                4,
                0,
                1500,
                100.47,
            ],
            '4' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                0,
                0,
                300,
                14.68,
            ],
            '5' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                2,
                0,
                500,
                25.63,
            ],
            '6' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                4,
                0,
                1500,
                100.47,
            ],
            '7' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_MARRIED,
                false,
                0,
                0,
                300,
                10.6,
            ],
            '8' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_MARRIED,
                false,
                2,
                0,
                500,
                19.96,
            ],
            '9' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_MARRIED,
                false,
                4,
                0,
                1500,
                89.3,
            ],
            '10' => [
                'January 1, 2019 8am',
                HawaiiIncome::FILING_MARRIED,
                false,
                4,
                100,
                1500,
                189.3,
            ],
        ];
    }
}
