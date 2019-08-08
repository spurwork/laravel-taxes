<?php

namespace Appleton\Taxes\Countries\US\California\SanFranciscoPayrollExpenseTax;

use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollExpenseTax\SanFranciscoPayrollExpenseTax;
use Carbon\Carbon;

class SanFranciscoPayrollExpenseTaxTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testSanFranciscoPayrollExpenseTax($date, $work_location, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings, $work_location) {
            $taxes->setHomeLocation($this->getLocation('us.california.sanfrancisco'));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(SanFranciscoPayrollExpenseTax::class));
    }

    public function provideTestData()
    {
        return [
            // exempt
            '0' => [
                'January 1, 2019 8am',
                'us.california.sanfrancisco',
                0,
                0,
                null,
            ],
            // under 300,000 total gross payroll
            '1' => [
                'January 1, 2019 8am',
                'us.california.sanfrancisco',
                400,
                5000,
                null,
            ],
            // exactly 300,000 total gross payroll
            '2' => [
                'January 1, 2019 8am',
                'us.california.sanfrancisco',
                1000,
                300000,
                null,
            ],
            // over 300,000 total gross payroll
            '3' => [
                'January 1, 2019 8am',
                'us.california.sanfrancisco',
                1000,
                300001,
                3.8,
            ],
            // works in Alabama
            '3' => [
                'January 1, 2019 8am',
                'us.alabama',
                1000,
                300001,
                null,
            ],
        ];
    }
}
