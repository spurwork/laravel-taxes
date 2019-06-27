<?php
 namespace Appleton\Taxes\Unit\Countries\US\Louisiana\LouisianaIncome;

use Appleton\Taxes\Countries\US\Louisiana\LouisianaIncome\LouisianaIncome;
use Appleton\Taxes\Models\Countries\US\Louisiana\LouisianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class LouisianaIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testLouisianaIncome($date, $filing_status, $exempt, $exemptions, $dependents, $earnings, $result)
    {
        LouisianaIncomeTaxInformation::forUser($this->user)->update([
            'dependents' => $dependents,
            'exempt' => $exempt,
            'exemptions' => $exemptions,
            'filing_status' => $filing_status,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.louisiana'));
            $taxes->setWorkLocation($this->getLocation('us.louisiana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(LouisianaIncome::class));
    }

    public function provideTestData()
    {
        // date
        // filing status
        // exempt
        // exemptions
        // dependents
        // earnings
        // result
        return [
            '0' => [ // Example 1 on http://revenue.louisiana.gov/TaxForms/1306(1_12)TF.pdf
                'January 1, 2019 8am',
                LouisianaIncome::FILING_SINGLE,
                false,
                1,
                2,
                700,
                19.42,
            ],
            '1' => [ // Example 2 (adjusted for weekly pay) on http://revenue.louisiana.gov/TaxForms/1306(1_12)TF.pdf
                'January 1, 2019 8am',
                LouisianaIncome::FILING_MARRIED,
                false,
                2,
                3,
                2300,
                78.55,
            ],
            '2' => [ // exempt
                'January 1, 2019 8am',
                LouisianaIncome::FILING_SINGLE,
                true,
                2,
                3,
                2300,
                0.0,
            ],
            '3' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_SINGLE,
                false,
                0,
                0,
                300,
                7.25, // 7.37 from test cases
            ],
            '4' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_SINGLE,
                false,
                0,
                1,
                300,
                6.85,
            ],
            '5' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_SINGLE,
                false,
                1,
                1,
                300,
                5.03,
            ],
            '6' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_SINGLE,
                false,
                2,
                2,
                300,
                2.81,
            ],
            '7' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_SINGLE,
                false,
                2,
                2,
                1000,
                29.23
            ],
            '8' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_MARRIED,
                false,
                0,
                0,
                300,
                6.30,
            ],
            '9' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_MARRIED,
                false,
                1,
                0,
                300,
                4.48,
            ],
            '10' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_MARRIED,
                false,
                1,
                1,
                300,
                4.07,
            ],
            '11' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_MARRIED,
                false,
                2,
                2,
                300,
                1.85,
            ],
            '12' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_MARRIED,
                false,
                2,
                2,
                600,
                10.12,
            ],
            '13' => [
                'January 1, 2019 8am',
                LouisianaIncome::FILING_MARRIED,
                false,
                2,
                2,
                2000,
                63.66,
            ],
        ];
    }
}
