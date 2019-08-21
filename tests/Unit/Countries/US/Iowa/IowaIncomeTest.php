<?php

namespace Appleton\Taxes\Unit\Countries\US\Iowa\IowaIncome;

use Appleton\Taxes\Countries\US\Iowa\IowaIncome\IowaIncome;
use Appleton\Taxes\Models\Countries\US\Iowa\IowaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class IowaIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testIowaIncome($date, $exempt, $allowances, $earnings, $result)
    {
        IowaIncomeTaxInformation::forUser($this->user)->update([
            'allowances' => $allowances,
            'exempt' => $exempt,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.iowa'));
            $taxes->setWorkLocation($this->getLocation('us.iowa'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(IowaIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // allowances
        // earnings
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                0,
                300,
                7.47,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                2,
                700,
                23.72,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                0,
                700,
                28.22,
            ],
        ];
    }
}
