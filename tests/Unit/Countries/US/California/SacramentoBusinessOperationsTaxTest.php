<?php

namespace Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsTax;

use Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsTax\SacramentoBusinessOperationsTax;
use Carbon\Carbon;

class SacramentoBusinessOperationsTaxTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testSacramentoBusinessOperationsTax($date, $work_location, $earnings, $ytd_earnings, $ytd_liabilities, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings, $work_location, $ytd_liabilities) {
            $taxes->setHomeLocation($this->getLocation('us.california.sacramento'));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
            $taxes->setYtdLiabilities($ytd_liabilities);
        });

        $this->assertSame($result, $results->getTax(SacramentoBusinessOperationsTax::class));
    }

    public function provideTestData()
    {
        // date
        // work_location
        // earnings
        // ytd earnings
        // ytd liabilities
        // result
        return [
            // should be 30, just the single liability
            '0' => [
                'January 1, 2019 8am',
                'us.california.sacramento',
                400,
                0,
                0,
                30
            ],
            '1' => [
                'January 1, 2019 8am',
                'us.california.sacramento',
                400,
                1000,
                0,
                0.16
            ],
            '3' => [
                'January 1, 2019 8am',
                'us.california.sacramento',
                400,
                1000,
                5000,
                null
            ],
        ];
    }
}
