<?php

namespace Appleton\Taxes\Unit\Countries\US\Arkansas;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Arkansas\ArkansasUnemployment\ArkansasUnemployment;
use Carbon\Carbon;
use TestCase;

class ArkansasUnemploymentTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNorthDakotaUnemployment(int $earnings, int $ytd_earnings, ?float $expected_amount): void
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->taxes->calculate(function (Taxes $taxes) use ($earnings, $ytd_earnings) {
            $taxes->setHomeLocation($this->getLocation('us.arkansas'));
            $taxes->setWorkLocation($this->getLocation('us.arkansas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertThat($expected_amount, self::identicalTo($results->getTax(ArkansasUnemployment::class)));
    }

    public function provideTestData(): array
    {
        return [
            'under wages base' => [100, 9800, 3.2],
            'at wages base' => [100, 9900, 3.2],
            'cross wages base' => [100, 9950, 1.6],
            'over wages base' => [100, 10050, null],
        ];
    }

}
