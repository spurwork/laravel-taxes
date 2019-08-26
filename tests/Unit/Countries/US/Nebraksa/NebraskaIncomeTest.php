<?php

namespace Appleton\Taxes\Unit\Countries\US\Nebraska\NebraskaIncome;

use Appleton\Taxes\Countries\US\Nebraska\NebraskaIncome\NebraskaIncome;
use Appleton\Taxes\Models\Countries\US\Nebraska\NebraskaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class NebraskaIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNebraskaIncome($date, $exempt, $lower_withholding_than_lb223, $filing_status, $allowances, $earnings, $result)
    {
        NebraskaIncomeTaxInformation::forUser($this->user)->update([
            'allowances' => $allowances,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
            'lower_withholding_than_lb223' => $lower_withholding_than_lb223,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.nebraska'));
            $taxes->setWorkLocation($this->getLocation('us.nebraska'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(NebraskaIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // filing status
        // allowances
        // earnings
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                false,
                NebraskaIncome::FILING_SINGLE,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_SINGLE,
                0,
                300,
                7.36,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_SINGLE,
                1,
                700,
                26.71,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_SINGLE,
                2,
                1500,
                77.82,
            ],
            '4' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_SINGLE,
                3,
                3000,
                179.45,
            ],
            '5' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_MARRIED,
                2,
                300,
                2.19,
            ],
            '6' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_MARRIED,
                2,
                700,
                17.04,
            ],
            '7' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_MARRIED,
                11,
                1500,
                43.88,
            ],
            '8' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_MARRIED,
                3,
                3000,
                168.31,
            ],
            '9' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                300,
                7.36,
            ],
            '10' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                1,
                700,
                26.71,
            ],
            '11' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                2,
                1500,
                77.82,
            ],
            '12' => [
                'January 1, 2019 8am',
                false,
                false,
                NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                3,
                3000,
                179.45,
            ],
            '13' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_SINGLE,
                0,
                300,
                7.36,
            ],
            '14' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_SINGLE,
                1,
                700,
                26.71,
            ],
            '15' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_SINGLE,
                2,
                1500,
                77.82,
            ],
            '16' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_SINGLE,
                3,
                3000,
                179.45,
            ],
            '17' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_MARRIED,
                2,
                300,
                2.31,
            ],
            '18' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_MARRIED,
                2,
                700,
                17.04,
            ],
            '19' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_MARRIED,
                11,
                1500,
                43.88,
            ],
            '20' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_MARRIED,
                3,
                3000,
                168.31,
            ],
            '21' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                300,
                7.36,
            ],
            '22' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                1,
                700,
                26.71,
            ],
            '23' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                2,
                1500,
                77.82,
            ],
            '24' => [
                'January 1, 2019 8am',
                false,
                true,
                NebraskaIncome::FILING_HEAD_OF_HOUSEHOLD,
                3,
                3000,
                179.45,
            ],
        ];
    }
}
