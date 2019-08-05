<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkIncome;

use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;
use Carbon\Carbon;

class NewYorkIncomeTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNewYorkIncome($date, $filing_status, $allowances,
                                      $additional_withholding, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        NewYorkIncomeTaxInformation::forUser($this->user)
            ->update([
                'ny_allowances' => $allowances,
                'nyc_allowances' => 10, // should not be used
                'filing_status' => $filing_status,
                'ny_additional_withholding' => $additional_withholding,
                'nyc_additional_withholding' => 10, // should not be used
                'yonkers_additional_withholding' => 10, // should not be used
            ]);

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(NewYorkIncome::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                0,
                0,
                145,
                0.1,
            ],
            '1' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                0,
                0,
                300,
                6.3,
            ],
            '2' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                2,
                0,
                500,
                14.6,
            ],
            '3' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                3,
                0,
                700,
                25.53,
            ],
            '4' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                3,
                0,
                900,
                37.95,
            ],
            '5' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                2,
                0,
                1300,
                63.98,
            ],
            '6' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_SINGLE,
                11,
                0,
                1000,
                34.6,
            ],
            '7' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_MARRIED,
                0,
                0,
                145,
                null,
            ],
            '8' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_MARRIED,
                0,
                0,
                300,
                5.88,
            ],
            '9' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_MARRIED,
                2,
                0,
                500,
                13.97,
            ],
            '10' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_MARRIED,
                3,
                0,
                700,
                24.87,
            ],
            '11' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_MARRIED,
                3,
                0,
                900,
                37.29,
            ],
            '12' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_MARRIED,
                2,
                0,
                2000,
                107.51,
            ],
            '13' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_MARRIED,
                11,
                0,
                1000,
                33.95,
            ],
            '14' => [
                'January 1, 2019 8am',
                NewYorkIncome::FILING_MARRIED,
                11,
                10,
                1000,
                43.95,
            ],
        ];
    }
}
