<?php

namespace Appleton\Taxes\Unit\Countries\US\Oregon\OregonIncome;

use Appleton\Taxes\Countries\US\Oregon\OregonIncome\OregonIncome;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class OregonIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testOregonIncome($date, $exempt, $filing_status, $exemptions, $earnings, $additional_withholding, $result)
    {
        OregonIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => $exemptions,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
            'additional_withholding' => $additional_withholding,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.oregon'));
            $taxes->setWorkLocation($this->getLocation('us.oregon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(OregonIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // filing status
        // exemptions
        // earnings
        // additional withholding
        // results
        return [
            // exempt, should be null
            '0' => [
                'July 10, 2019 8am',
                true,
                OregonIncome::FILING_SINGLE,
                0,
                300,
                0,
                null,
            ],
            '1' => [
                'July 10, 2019 8am',
                false,
                OregonIncome::FILING_SINGLE,
                0,
                300,
                0,
                20.13,
            ],
            '2' => [
                'July 10, 2019 8am',
                false,
                OregonIncome::FILING_SINGLE,
                2,
                600,
                0,
                35.97,
            ],
            '3' => [
                'July 10, 2019 8am',
                false,
                OregonIncome::FILING_SINGLE,
                3,
                1200,
                0,
                66.9,
            ],
            '4' => [
                'July 10, 2019 8am',
                false,
                OregonIncome::FILING_MARRIED,
                0,
                1000,
                0,
                61.37,
            ],
            '5' => [
                'July 10, 2019 8am',
                false,
                OregonIncome::FILING_MARRIED,
                4,
                2000,
                0,
                134.94,
            ],
            '6' => [
                'July 10, 2019 8am',
                false,
                OregonIncome::FILING_MARRIED,
                4,
                2000,
                20,
                154.94,
            ],
            '7' => [
                'July 10, 2019 8am',
                false,
                OregonIncome::FILING_MARRIED,
                4,
                5000,
                0,
                417.77,
            ],
        ];
    }
}
