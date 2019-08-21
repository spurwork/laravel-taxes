<?php

namespace Appleton\Taxes\Unit\Countries\US\Connecticut\ConnecticutIncome;

use Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\ConnecticutIncome;
use Appleton\Taxes\Models\Countries\US\Connecticut\ConnecticutIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class ConnecticutIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testConnecticutIncome($date, $exempt, $filing_status, $reduced_withholding, $additional_withholding, $earnings, $result)
    {
        ConnecticutIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => $additional_withholding,
            'reduced_withholding' => $reduced_withholding,
            'filing_status' => $filing_status,
            'exempt' => $exempt,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.connecticut'));
            $taxes->setWorkLocation($this->getLocation('us.connecticut'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(ConnecticutIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // filing status
        // reduced withholding
        // additional withholding
        // earnings
        // result
        return [
            // exempt, should be null
            // '0' => [
            //     'January 1, 2019 8am',
            //     true,
            //     ConnecticutIncome::WITHHOLDING_CODE_C,
            //     0,
            //     0,
            //     300,
            //     null,
            // ],
            // '1' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_A,
            //     0,
            //     0,
            //     300,
            //     .73,
            // ],
            // '2' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_A,
            //     0,
            //     0,
            //     576.93,
            //     18.17,
            // ],
            // '3' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_A,
            //     20,
            //     20,
            //     576.93,
            //     18.17,
            // ],
            // '4' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_A,
            //     0,
            //     0,
            //     1153.8,
            //     56.34,
            // ],
            // '5' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_B,
            //     0,
            //     0,
            //     300,
            //     null,
            // ],
            // '6' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_B,
            //     0,
            //     0,
            //     576.93,
            //     4.13,
            // ],
            // '7' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_B,
            //     20,
            //     0,
            //     576.93,
            //     null,
            // ],
            // '8' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_B,
            //     0,
            //     20,
            //     576.93,
            //     24.13,
            // ],
            // '9' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_B,
            //     0,
            //     0,
            //     1153.8,
            //     46.38,
            // ],
            // '10' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_B,
            //     0,
            //     0,
            //     6730.8,
            //     394.43,
            // ],
            // '11' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_C,
            //     0,
            //     0,
            //     300,
            //     null,
            // ],
            // '12' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_C,
            //     0,
            //     0,
            //     576.93,
            //     1.04,
            // ],
            // '13' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_C,
            //     0,
            //     0,
            //     1153.8,
            //     34.61,
            // ],
            // '14' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_C,
            //     0,
            //     0,
            //     6730.8,
            //     375.0,
            // ],
            // '15' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_D,
            //     0,
            //     0,
            //     300,
            //     11.15,
            // ],
            // '16' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_D,
            //     0,
            //     0,
            //     576.93,
            //     25.0,
            // ],
            // '17' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_D,
            //     0,
            //     0,
            //     1153.8,
            //     56.34,
            // ],
            // '18' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_D,
            //     0,
            //     0,
            //     6730.8,
            //     463.46,
            // ],
            // '19' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_F,
            //     0,
            //     0,
            //     300,
            //     0.09,
            // ],
            // '20' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_F,
            //     0,
            //     0,
            //     576.93,
            //     9.81,
            // ],
            // '21' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_F,
            //     0,
            //     0,
            //     1153.8,
            //     49.67,
            // ],
            // '22' => [
            //     'January 1, 2019 8am',
            //     false,
            //     ConnecticutIncome::WITHHOLDING_CODE_F,
            //     0,
            //     0,
            //     6730.8,
            //     463.46,
            // ],
            '23' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::WITHHOLDING_CODE_E,
                0,
                0,
                300,
                null,
            ],
            '24' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::WITHHOLDING_CODE_E,
                0,
                0,
                576.93,
                null,
            ],
            '25' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::WITHHOLDING_CODE_E,
                0,
                0,
                1153.8,
                null,
            ],
            '26' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::WITHHOLDING_CODE_E,
                0,
                0,
                6730.8,
                null,
            ],
        ];
    }
}
