<?php

namespace Appleton\Taxes\Unit\Countries\US\Delaware\DelawareIncome;

use Appleton\Taxes\Countries\US\Delaware\DelawareIncome\DelawareIncome;
use Appleton\Taxes\Models\Countries\US\Delaware\DelawareIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class DelawareIncomeTest extends TestCase
{
    /**
    * @dataProvider provideTestData
    */
    public function testDelawareIncome($date, $filing_status, $exempt, $exemptions, $additional_withholding, $earnings, $result)
    {
        DelawareIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => $additional_withholding,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
            'exemptions' => $exemptions,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.delaware'));
            $taxes->setWorkLocation($this->getLocation('us.delaware'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(DelawareIncome::class));
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
                DelawareIncome::FILING_SINGLE,
                true,
                0,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                DelawareIncome::FILING_MARRIED_FILING_SEPARATELY,
                false,
                0,
                0,
                300,
                7.19,
            ],
            '2' => [
                'January 1, 2019 8am',
                DelawareIncome::FILING_MARRIED_FILING_JOINTLY,
                false,
                0,
                0,
                700,
                24.48,
            ],
            '3' => [
                'January 1, 2019 8am',
                DelawareIncome::FILING_MARRIED_FILING_SEPARATELY,
                false,
                0,
                0,
                35,
                null,
            ],
            '4' => [
                'January 1, 2019 8am',
                DelawareIncome::FILING_MARRIED_FILING_SEPARATELY,
                false,
                0,
                0,
                150,
                1.08,
            ],
            '5' => [
                'January 1, 2019 8am',
                DelawareIncome::FILING_MARRIED_FILING_SEPARATELY,
                false,
                2,
                0,
                300,
                2.96,
            ],
            '6' => [
                'January 1, 2019 8am',
                DelawareIncome::FILING_SINGLE,
                false,
                2,
                0,
                300,
                2.96,
            ],
            '7' => [
                'January 1, 2019 8am',
                DelawareIncome::FILING_SINGLE,
                false,
                2,
                20,
                300,
                22.96,
            ],
        ];
    }
}
