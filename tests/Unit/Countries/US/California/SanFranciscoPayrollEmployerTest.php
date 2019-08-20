<?php

namespace Appleton\Taxes\Unit\Countries\US\California;

use Appleton\Taxes\Classes\PayrollLiabilities;
use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollEmployer\SanFranciscoPayrollEmployer;
use Carbon\Carbon;
use TestCase;

class SanFranciscoPayrollEmployerTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testSanFranciscoPayrollEmployer(int $wages,
                                                    int $ytd_wages,
                                                    ?float $expected_amount,
                                                    ?int $expected_wages): void
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->payroll_liabilities->calculate(function (PayrollLiabilities $payroll_liabilities)
        use ($wages, $ytd_wages) {
            $payroll_liabilities->setWorkLocation($this->getLocation('us.california.san_francisco'));
            $payroll_liabilities->setWages($wages);
            $payroll_liabilities->setYtdWages($ytd_wages);
            $payroll_liabilities->setYtdLiabilities(0);
        });

        self::assertThat($results->getLiability(SanFranciscoPayrollEmployer::class), self::identicalTo($expected_amount));
        self::assertThat($results->getWages(SanFranciscoPayrollEmployer::class), self::identicalTo($expected_wages));
    }

    /**
     * @return array {
     * @type array {
     * @type int $wages
     * @type int $ytd_wages
     * @type ?float $result
     *     }
     * }
     */
    public function dataProvider(): array
    {
        return [
            'with ytd wages under start' => [100, 2999899, null, null],
            'with ytd wages equal start' => [100, 2999900, null, null],
            'with ytd wages over start' => [100, 2999999, 1, 100],
            'wages under start' => [2999900, 0, null, null, 2999900],
            'wages equal start' => [3000000, 0, null, null, 3000000],
            'wages over start' => [3000100, 0, 1, 3000100],
            'combined wages' => [2000000, 2000000, 3800, 2000000],
        ];
    }
}
