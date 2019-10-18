<?php

namespace Appleton\Taxes\Unit\Countries\US\Vermont;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Vermont\VermontUnemployment\VermontUnemployment;
use Carbon\Carbon;
use TestCase;

class VermontUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * @dataProvider provideTestData
     */
    public function testNorthDakotaUnemployment(int $earnings, int $ytd_earnings, ?float $expected_amount): void
    {
        $results = $this->taxes->calculate(function (Taxes $taxes) use ($earnings, $ytd_earnings){
            $taxes->setHomeLocation($this->getLocation('us.vermont'));
            $taxes->setWorkLocation($this->getLocation('us.vermont'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertThat($expected_amount, self::identicalTo($results->getTax(VermontUnemployment::class)));
    }

    public function provideTestData():array
    {
        return [
            'under wages base' => [100, 15400, 1.0],
            'at wages base' => [100, 15500, 1.0],
            'cross wages base' => [100, 15550, 0.5],
            'over wages base' => [100, 15600, null],
        ];
    }
}
